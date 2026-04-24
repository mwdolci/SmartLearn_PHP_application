<?php

require_once 'app/models/Course.php';

class CreateCourseController {

    //  affiche la page de création d'un cours
    public function index() {

        $nav = NavigationHelper::getNavigationButton();

        return Helper::view("create_course", [
            'title'    => 'Créer un cours',
            'btnAbout' => $nav['btnAbout'],
            'btnAboutLink'  => $nav['btnAboutLink'],
            'user'     => $_SESSION['user'],
            'old'      => []
        ]);
    }

    // pour créer un cours
    public function add() {

        // Vérifier méthode POST
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            Helper::redirect('create-course');
        }

        // Nettoyage des données
        $name        = trim($_POST['name'] ?? '');
        $descriptive = trim($_POST['descriptive'] ?? '');
        $delay       = trim($_POST['delay'] ?? '');
        $date_start  = trim($_POST['date_start'] ?? '');
        $date_end    = trim($_POST['date_end'] ?? '');
        $time_start  = trim($_POST['time_start'] ?? '');
        $time_end    = trim($_POST['time_end'] ?? '');
        $days        = $_POST['days'] ?? [];
        $period      = trim($_POST['period'] ?? '');
        $sites       = trim($_POST['sites'] ?? '');
        $price       = trim($_POST['price'] ?? '');

        $teacher_id = $_SESSION['user']['id'];

        $allowedDays = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi']; // Tous les jours sauf dimanche
        $days = array_values(array_intersect($days, $allowedDays)); // Filtrer les jours pour n'inclure que ceux autorisés
        $daysString = implode(', ', $days); // Convertir le tableau de jours en une chaîne

        // Validation
        if (
            $name === '' || $descriptive === '' || $delay === '' ||
            $date_start === '' || $date_end === '' || $time_start === '' ||
            $time_end === '' || $daysString === '' || $period === '' || $sites === '' || $price === ''
        ) {
            return $this->error("Tous les champs sont obligatoires.");
        }

        // Vérification de l'ordre des dates
        if ($delay >= $date_start) {
            return $this->error("La date limite d'inscription doit être antérieure à la date de début.");
        }

        if ($date_start > $date_end) {
            return $this->error("La date de début doit être antérieure à la date de fin.");
        }

        // Vérification de l'ordre des heures
        if ($time_start >= $time_end) {
            return $this->error("L'heure de début doit être antérieure à l'heure de fin.");
        }

        // Création du cours via le modèle générique
        $course = new Course();
        $course->name        = $name;
        $course->descriptive = $descriptive;
        $course->delay       = $delay;
        $course->date_start  = $date_start;
        $course->date_end    = $date_end;
        $course->time_start  = $time_start;
        $course->time_end    = $time_end;
        $course->period      = $period;
        $course->sites       = $sites;
        $course->price       = $price;
        $course->days        = $daysString;
        $course->teacher_id  = $teacher_id;

        try {
            $course->create();

            $_SESSION['flash_message'] = "Cours créé avec succès.";
            $_SESSION['flash_type'] = "success";
            Helper::redirect('list'); // Redirige vers la page de liste des cours après création, cela permet au teacher de vérifier directement le résultat de sa création

        } catch (Exception $e) {

            if (App::get('config')['APP_ENV'] === 'dev') {
                // $_SESSION['flash_message'] = "Erreur : " . $e->getMessage();
                throw $e;
            } else {
                $_SESSION['flash_message'] = "Erreur lors de la création du cours.";
            }

            $_SESSION['flash_type'] = "error";

            error_log("Course creation error: " . $e->getMessage());
            Helper::redirect('create-course');
        }
    }

    private function error($msg){
        $nav = NavigationHelper::getNavigationButton();
        return Helper::view("create_course", [
            'title' => 'Créer un cours',
            'btnAbout' => $nav['btnAbout'],
            'btnAboutLink'  => $nav['btnAboutLink'],
            'message' => $msg,
            'type' => "error",
            'old' => $_POST
        ]);
    }
}
