<?php

require_once 'app/models/Course.php';
require_once 'helpers/NavigationHelper.php';

class ListController {

    // affiche la page pour consulter la liste des cours
    public function index() {

        $isAdmin = ($_SESSION['user']['role'] ?? '') === 'teacher';

        $courses = Course::fetchAll();

        $nav = NavigationHelper::getNavigationButton();
        
        return Helper::view("list", [
            'title' => 'Liste de cours',
            'btnAbout' => $nav['btnAbout'],
            'btnAboutLink' => $nav['btnAboutLink'],
            'courses' => $courses,
            'isAdmin' => $isAdmin
        ]);
    }
}