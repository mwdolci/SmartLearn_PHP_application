<?php

class Router {
  protected $routes = [];

  public function define($routes) {
    $this->routes = $routes;
  }

  public function direct($uri) {
    // example.com/about/us
    // Remove the parameters
    $uri = parse_url($uri)["path"]; // more info: http://php.net/manual/en/function.parse-url.php

    // remove installation prefix
    $prefix = App::get('config')['install_prefix'] ?? null;
    if (isset($prefix) && !empty($prefix)) {
      if (strncmp($uri, $prefix, strlen($prefix)) == 0) {
        if (empty($uri = substr($uri, strlen($prefix) + 1))) {
          $uri = "";
        }
      }
    }

    if(array_key_exists ($uri, $this->routes)) {
      // Vérification d’accès
      $this->checkAccess($uri);

      // En PHP 5.6 et suivants, la liste des arguments peut inclure
      // le mot clé ... pour indiquer que cette fonction accepte un nombre
      // variable d'arguments. Les arguments seront passés dans la variable
      // fournie sous forme d'un tableau
      return $this->callAction(
          ...explode('@', $this->routes[$uri]['action']) // ... splat operator, voir http://php.net/manual/fr/migration56.new-features.php
                                                // (fonctions variadiques http://php.net/manual/fr/functions.arguments.php#functions.variable-arg-list)
                                                // explode (split a string by a string): http://php.net/manual/en/function.explode.php
      );
    }

    if (App::get('config')['APP_ENV'] === 'dev') {
        throw new Exception("No routes defined for this URI.");
    }else{
      Helper::view('error', [
          'title' => 'Page introuvable – erreur 404',
          'message' => "Cette page n'existe pas."
      ], public: true);
      exit;
    }
  }

  // call a specific action (method) of a controller
  // if not action is specified, the action index() is called by default
  protected function callAction($controller, $action = 'index') {
    require_once ("app/controllers/" . $controller . ".php");
    $control = new $controller;

    if(! method_exists($control, $action)) {
      if (App::get('config')['APP_ENV'] === 'dev') {
        throw new Exception("$controller does not respond to the action $action.");
      }else{
        Helper::view('error', [
            'title' => 'Page introuvable – erreur 404',
            'message' => "Cette action n'existe pas."
        ], public: true);
        exit;
      }
    }
    return $control->$action();
  }

  protected function checkAccess($uri) {

    $route = $this->routes[$uri];

    // Vérification login
    if (($route['auth'] ?? false) === true && empty($_SESSION['user'])) {
      Helper::redirect('login');
    }

    // Vérification rôle
    if (isset($route['role']) && ($_SESSION['user']['role'] ?? '') !== $route['role']) {
      Helper::redirect('list');
    }
  }

  public static function load($file) {
    // About 'new static':
    // more info: http://php.net/manual/en/language.oop5.late-static-bindings.php
    // and here: https://stackoverflow.com/questions/15898843/what-means-new-static
    $router = new static;
    require_once 'app/' . $file;

    return $router;
  }
}
