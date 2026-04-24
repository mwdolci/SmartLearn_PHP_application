<?php

// Le try catch ici est un filet de sécurité global qui permet de capturer toute exception non gérée qui pourrait survenir dans l'application.
try {
    require_once 'core/bootstrap.php';
    $uri = Request::uri();
    $router = Router::load('routes.php');
    $router->direct($uri);
} catch (Exception $e) {

    error_log($e->getMessage());

    // Même message entre dev et prod à cet endroit car pas d'exactitude de connaitre APP_ENV ici (potentiellement trop tôt).
    //echo "Une erreur inattendue est survenue." . $e->getMessage();
    Helper::view('error', [
        'title' => 'Erreur interne – 500',
        'message' => "Une erreur inattendue est survenue : " . $e->getMessage()
    ], public: true);
    exit;

}