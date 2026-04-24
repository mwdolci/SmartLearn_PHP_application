<?php

/**
 *
 */
class Connection{
  public static function make($config) {
    try {
      $pdo = new PDO(
        $config['connection'].';port='.$config['port'].';dbname='.$config['dbname'].';charset='.$config['charset'],
        $config['username'],
        $config['password'],
        $config['options']
      );

      return $pdo;
    } catch (PDOException $e) {

      error_log("Database connection error: " . $e->getMessage());

      if (App::get('config')['APP_ENV'] === 'dev') {
        throw new Exception("La connexion à la base a échoué : " . $e->getMessage(), 0, $e);
      } else {
          Helper::view('error', [
            'title' => 'Erreur serveur – erreur 500',
            'message' => "Erreur de connexion à la base de données."
          ], public: true);
          exit;

      }
    }
  }
}