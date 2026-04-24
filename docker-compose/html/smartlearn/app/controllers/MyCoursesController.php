<?php

require_once 'app/models/Enrollment.php';

class MyCoursesController {

    public function index() {

        $user = $_SESSION['user'];

        // Récupérer les cours auxquels l'étudiant est inscrit
        $courses = Enrollment::getCoursesByUserId($user['id']);

        // Navigation dynamique (bouton retour / admin)
        $nav = NavigationHelper::getNavigationButton();

        return Helper::view("my_courses", [
            'title'     => 'Mes cours',
            'btnAbout'  => $nav['btnAbout'],
            'btnAboutLink'   => $nav['btnAboutLink'],
            'user'      => $user,
            'courses'   => $courses
        ]);
    }
}
