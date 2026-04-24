<?php

$router->define([

    // Page d'accueil
    ''                  => ['action' => 'IndexController@index', 'auth' => false],
    'index'             => ['action' => 'IndexController@index', 'auth' => false],

    // À propos
    'about'             => ['action' => 'AboutController@index', 'auth' => false],

    // Authentification
    'login'             => ['action' => 'LoginController@index', 'auth' => false],
    'login-user'        => ['action' => 'LoginController@login', 'auth' => false],
    'logout'            => ['action' => 'LoginController@logout', 'auth' => true],

    // Gestion du compte utilisateur
    'user'              => ['action' => 'UserController@index', 'auth' => true],
    'update-user'       => ['action' => 'UserController@update', 'auth' => true],
    'delete-user'       => ['action' => 'UserController@delete', 'auth' => true],

    // Création de compte
    'register'          => ['action' => 'UserController@register', 'auth' => false],
    'create-user'       => ['action' => 'UserController@add', 'auth' => false],

    // Liste des cours
    'list'              => ['action' => 'ListController@index', 'auth' => true],

    // Inscription à un cours
    'enroll-course'     => ['action' => 'EnrollmentController@add', 'auth' => true],

    // Suivi des étudiants (enseignant)
    'student-progress'  => ['action' => 'EnrollmentController@studentProgress', 'auth' => true, 'role' => 'teacher'],
    'update-pastille'   => ['action' => 'EnrollmentController@updatePastille', 'auth' => true, 'role' => 'teacher'],

    // Cours de l'étudiant
    'my-courses'        => ['action' => 'MyCoursesController@index', 'auth' => true],

    // Création de cours
    'create-course'     => ['action' => 'CreateCourseController@index', 'auth' => true, 'role' => 'teacher'],
    'add-course'        => ['action' => 'CreateCourseController@add', 'auth' => true, 'role' => 'teacher']
]);