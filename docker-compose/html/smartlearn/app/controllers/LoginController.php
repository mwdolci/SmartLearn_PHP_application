<?php
require_once 'app/models/User.php';

class LoginController {

    // affiche la page login
    public function index() {

        $nav = NavigationHelper::getNavigationButton();
        
        // afficher la vue login
        $view = Helper::view("login", [
            'title'=> 'Bienvenu sur SmartLearn !',
            'btnAbout' => $nav['btnAbout'],
            'btnAboutLink' => $nav['btnAboutLink'],
            'btName' => "Créer un compte"
        ], public: true);

        // après affichage du message flash
        if (isset($_SESSION['flash_message'])) {
            session_destroy();
        }

        return $view;
    }

    // pour ce connecter à la platform
    public function login() {

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            Helper::redirect('login');
        }

        $email = trim($_POST['login_email'] ?? '');
        $password = trim($_POST['login_password'] ?? '');

        if ($email === '' || $password === '') {
            return $this->renderLogin("Email et mot de passe obligatoires.", "error");
        }

        $user = User::findByEmail($email);

        if (!$user || !password_verify($password, $user->password)) {
            return $this->renderLogin("Identifiants invalides.", "error");
        }

        $_SESSION['user'] = [
            'id' => $user->id,
            'name' => $user->name,
            'forename' => $user->forename,
            'email' => $user->email,
            'role' => $user->role
        ];

        Helper::redirect('list');
    }

    private function renderLogin($message = null, $type = null) {
        $nav = NavigationHelper::getNavigationButton();

        return Helper::view("login", [
            'title'=> 'Bienvenu sur SmartLearn !',
            'btnAbout' => $nav['btnAbout'],
            'btnAboutLink' => $nav['btnAboutLink'],
            'btName' => "Créer un compte",
            'message' => $message,
            'type' => $type
        ], public: true);
    }


    // quit la page des cours
    public function logout() {
        session_destroy();
        Helper::redirect('login');
    }
}
