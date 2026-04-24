<?php

require_once 'app/models/Enrollment.php';
require_once 'app/models/EnrollmentStatus.php';
require_once 'app/models/Course.php';

class EnrollmentController {

    // pour s'inscrire à un cours
    public function add() {

        // Vérifier méthode POST
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            Helper::redirect('list');
        }

        $user_id = $_SESSION['user']['id'] ?? null;
        $course_id = $_POST['course_id'] ?? null;

        // Validation
        // Vérifie utilisateur
        if (!$user_id) {
            $_SESSION['flash_message'] = "Utilisateur non connecté.";
            $_SESSION['flash_type'] = "error";
            Helper::redirect('login');
        }

        // Vérifie cours
        if (!$course_id) {
            $_SESSION['flash_message'] = "Cours manquant.";
            $_SESSION['flash_type'] = "error";
            Helper::redirect('list');
        }

        // Création via le modèle générique
        $enrollment = new Enrollment();
        $enrollment->user_id = $user_id;
        $enrollment->course_id = $course_id;

        try {
            $enrollment->create();

            $status = new EnrollmentStatus();
            $status->id = $enrollment->id;
            $status->create();

            $_SESSION['flash_message'] = "Inscription réussie !";
            $_SESSION['flash_type'] = "success";
            Helper::redirect('my-courses'); // Redirige vers la page avec les cours de l'utilisateur

        } catch (Exception $e) {

            // Cas particulier : contrainte UNIQUE (user_id, course_id)
            if (str_contains($e->getMessage(), 'unique_user_course')) {
                $_SESSION['flash_message'] = "Vous êtes déjà inscrit à ce cours.";
                $_SESSION['flash_type'] = "error";
                Helper::redirect('list');
            }
            
            if (App::get('config')['APP_ENV'] === 'dev') {
                $_SESSION['flash_message'] = "Erreur : " . $e->getMessage();
            } else {
                $_SESSION['flash_message'] = "Erreur lors de l'inscription.";
            }

            $_SESSION['flash_type'] = "error";

            error_log("Enrollment creation error: " . $e->getMessage());
            Helper::redirect('list'); // Reste sur la page de liste des cours en cas d'erreur
        }
    }

    // récupérer la progression des élèves
    public function studentProgress() {

        $user = $_SESSION['user'];

        // Vérifier rôle
        if (($user['role'] ?? '') !== 'teacher') {
            Helper::redirect('list');
        }

        // Récupérer uniquement les étudiants du prof
        $studentsCourses = Enrollment::getStudentsForTeacher($user['id']);

        $nav = NavigationHelper::getNavigationButton();

        return Helper::view('student_progress', [
            'title' => 'Suivi étudiants',
            'btnAbout' => $nav['btnAbout'],
            'btnAboutLink'  => $nav['btnAboutLink'],
            'user' => $user,
            'studentsCourses' => $studentsCourses
        ]);
    }

    // Update progression de l'élève sur une branche spécifique (appelé via JS AJAX)
    public function updatePastille(){

        // Par sécurité vérifie si c'est bien le teacher connecté qui fait la requête
        $user = $_SESSION['user'];
        if (($user['role'] ?? '') !== 'teacher') {
            echo json_encode(["success" => false, "error" => "Forbidden"]);
            exit();
        }

        $data = json_decode(file_get_contents('php://input'), true);

        $enrollmentStatus_id = trim($data['id'] ?? '');
        $name = trim($data['name'] ?? '');
        $state = trim($data['state'] ?? '');

        // Sécurité
        $allowed = [
            'inscription_status',
            'admissibilite_status',
            'paiement_status',
            'realisation_status',
            'certification_status'
        ];

        if (!in_array($name, $allowed)) {
            // Renvoie une réponse JSON au JavaScript
            echo json_encode(["success" => false, "error" => "Invalid field"]);
            exit();
        }

        // Cotrôle de la valeur est valide (white, green, red)
        $allowedStates = ['white', 'green', 'red'];
        if (!in_array($state, $allowedStates, true)) {
            echo json_encode(["success" => false, "error" => "Invalid state"]);
            exit();
        }

        // Charger l'objet complet
        $status = EnrollmentStatus::fetchId($enrollmentStatus_id);
        if (!$status) {
            // Renvoie une réponse JSON au JavaScript
            echo json_encode(["success" => false, "error" => "Enrollment not found"]);
            exit();
        }

        // Vérifie que l'inscription appartient bien à un cours du teacher connecté
        if (!Enrollment::belongsToTeacher($enrollmentStatus_id, $user['id'])) {
            echo json_encode(["success" => false, "error" => "Forbidden"]);
            exit();
        }

        // Modifier UNE propriété
        $status->$name = $state;

        try {
            // Sauvegarder via Model::update()
            $status->update();

            // Renvoie une réponse JSON au JavaScript
            echo json_encode([
                "success" => true,
                "id" => $enrollmentStatus_id,
                "name" => $name,
                "state" => $state
            ]);
        } catch (Exception $e) {
            error_log("EnrollmentStatus update error: " . $e->getMessage());
            echo json_encode([
                "success" => false,
                "error" => App::get('config')['APP_ENV'] === 'dev' ? $e->getMessage() : "Erreur lors de la mise à jour de la pastille."]);
        }

        exit();
    }
}
