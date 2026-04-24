<?php

require_once 'core/Router.php';
require_once 'core/Request.php';
require_once 'core/App.php';
require_once 'core/database/Connection.php';

session_start();

foreach (glob("helpers/*.php") as $file) {
    require_once $file;
}

App::load_config("config.php");

App::set('dbh', Connection::make(App::get('config')['database']));

// Si utilisateur est enseignant, il est considéré comme admin pour les vues
$isAdmin = ($_SESSION['user']['role'] ?? '') === 'teacher'; 
App::set('isAdmin', $isAdmin);

if ($_SERVER['REQUEST_URI'] !== '/about') {
    unset($_SESSION['previous_page']);
}