<?php
require_once 'app/models/User.php';

class UserController {

    // affiche le formulaire d'inscription
    public function register() {
        
        $nav = NavigationHelper::getNavigationButton();

        return Helper::view("user", [
            'title' => 'Créer un compte',
            'btnAbout' => $nav['btnAbout'],
            'btnAboutLink'   => $nav['btnAboutLink'],
            'btnLink' => 'login',
            'btName' => 'Créer un compte',
            'user' => (object)[
                'name' => '',
                'forename' => '',
                'email' => '',
                'role' => ''
            ]
        ], public: true);
    }

    // traite la création d'un utilisateur
    public function add() {

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            Helper::redirect('register');
        }

        $email = trim($_POST['email'] ?? '');
        $name = trim($_POST['name'] ?? '');
        $forename = trim($_POST['forename'] ?? '');
        $password = $_POST['password'] ?? '';
        $confirmation = $_POST['confirmation'] ?? '';
        $role = trim($_POST['role'] ?? '');

        // validations
        if ($email === '' || $name === '' || $forename === '' || $password === '' || $role === '') {
            return $this->registerError("Tous les champs sont obligatoires.");
        }

        if (User::findByEmail($email)) {
            return $this->registerError("Cet email existe déjà.");
        }

        if ($password !== $confirmation) {
            return $this->registerError("Les mots de passe ne correspondent pas.");
        }

        if (strlen($name) > 100 || strlen($forename) > 100) {
            return $this->registerError("Le nom ou le prénom est trop long.");
        }

        try {
            // création
            $user = new User();
            $user->email = $email;
            $user->name = $name;
            $user->forename = $forename;
            $user->password = password_hash($password, PASSWORD_DEFAULT);
            $user->role = $role;
            $user->create();

            $_SESSION['flash_message'] = "Utilisateur créé avec succès.";
            $_SESSION['flash_type'] = "success";

            Helper::redirect('login');

        } catch (Exception $e) {

            // Cas particulier : erreur SQL "Duplicate entry" (contrainte UNIQUE violée).
            // Cela peut arriver si deux utilisateurs soumettent le même email au même moment,
            // même si findByEmail() a déjà vérifié l'existence avant l'insertion.
            if (str_contains($e->getMessage(), 'Duplicate entry')) {
                $_SESSION['flash_message'] = "Cet email existe déjà.";
                $_SESSION['flash_type'] = "error";
                Helper::redirect('register');
            }

            // Cas général
            if (App::get('config')['APP_ENV'] === 'dev') {
                $_SESSION['flash_message'] = "Erreur : " . $e->getMessage();
            } else {
                $_SESSION['flash_message'] = "Erreur lors de la création de l'utilisateur.";
            }

            $_SESSION['flash_type'] = "error";

            error_log("User creation error: " . $e->getMessage());
            Helper::redirect('register');
        }
    }

    // met à jour un utilisateur existant
    public function update() {

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            Helper::redirect('user');
        }

        $email = trim($_POST['email'] ?? '');
        $name = trim($_POST['name'] ?? '');
        $forename = trim($_POST['forename'] ?? '');
        $role = trim($_POST['role'] ?? '');
        $password = $_POST['password'] ?? '';
        $confirmation = $_POST['confirmation'] ?? '';

        $id = $_SESSION['user']['id'];
        $user = User::fetchId($id);

        if (!$user) {
            return $this->updateError("Utilisateur introuvable.", $user);
        }

        // Sécurité : un utilisateur ne peut modifier que son propre compte
        if ($user->id !== $_SESSION['user']['id']) {
            Helper::redirect('list');
        }

        if (strlen($name) > 100 || strlen($forename) > 100) {
            return $this->updateError("Le nom ou le prénom est trop long.", $user);
        }

        // Vérifier si aucune modification n'a été faite
        $noChange =
            $email === $user->email &&
            $name === $user->name &&
            $forename === $user->forename &&
            $role === $user->role &&
            empty($password);

        if ($noChange) {
            return $this->updateError("Aucune modification détectée. Veuillez modifier au moins un champ.", $user);
        }

        // Mise à jour des champs
        $user->email = $email;
        $user->name = $name;
        $user->forename = $forename;
        $user->role = $role;

        // Mot de passe optionnel
        if (!empty($password)) {
            if ($password !== $confirmation) {
                return $this->updateError("Les mots de passe ne correspondent pas.", $user);
            }
            
            $user->password = password_hash($password, PASSWORD_DEFAULT);
        }

        // Vérifier si l'email est déjà utilisé par un autre utilisateur
        $existingUser = User::findByEmail($email);
        if ($existingUser && $existingUser->id != $user->id) {

            return $this->updateError("Cet email existe déjà.", $user);
        }

        try {
            $user->update();

            // Met à jour les données de la session
            $_SESSION['user']['id'] = $user->id;
            $_SESSION['user']['name'] = $user->name;
            $_SESSION['user']['forename'] = $user->forename;
            $_SESSION['user']['email'] = $user->email;
            $_SESSION['user']['role'] = $user->role;

            $_SESSION['flash_message'] = "Utilisateur modifié avec succès.";
            $_SESSION['flash_type'] = "success";

            Helper::redirect('list');

        } catch (Exception $e) {

            // Cas particulier : erreur SQL "Duplicate entry" (contrainte UNIQUE violée).
            // Cela peut arriver si deux utilisateurs soumettent le même email au même moment,
            // même si findByEmail() a déjà vérifié l'existence avant l'insertion.
            if (str_contains($e->getMessage(), 'Duplicate entry')) {
                $_SESSION['flash_message'] = "Cet email existe déjà.";
                $_SESSION['flash_type'] = "error";
                Helper::redirect('register');
            }

            if (App::get('config')['APP_ENV'] === 'dev') {
                $_SESSION['flash_message'] = "Erreur : " . $e->getMessage();
            } else {
                $_SESSION['flash_message'] = "Erreur lors de la mise à jour.";
            }

            $_SESSION['flash_type'] = "error";

            error_log("User update error: " . $e->getMessage());
            Helper::redirect('user');
        }
    }

    // affiche les informations du compte connecté
    public function index() {

        if (!isset($_SESSION['user'])) {
            Helper::redirect('login');
        }

        $user = User::fetchId($_SESSION['user']['id']);

        if (!$user) {
            return $this->updateError("Utilisateur introuvable dans la base.", $user);
        }

        $nav = NavigationHelper::getNavigationButton();
        
        return Helper::view("user", [
            'title' => 'Modifier votre compte',
            'btnAbout' => $nav['btnAbout'],
            'btnAboutLink'   => $nav['btnAboutLink'],
            'btName' => 'Mettre à jour',
            'btnLink' => 'list',
            'user' => $user
        ], public: true);
    }

    //  supprime le compte de l'utilisateur connecté
   public function delete() {

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            Helper::redirect('user');
        }

        $id = $_SESSION['user']['id'];
        $user = User::fetchId($id);

        // Sécurité : un utilisateur ne peut supprimer que son propre compte
        if ($user->id !== $_SESSION['user']['id']) {
            Helper::redirect('list');
        }

        try {
            if ($user) {
                $user->delete();
                $_SESSION['flash_message'] = "Compte supprimé.";
                $_SESSION['flash_type'] = "success";
            }

            unset($_SESSION['user']);   // Déconnecte l'utilisateur

            Helper::redirect('login');

        } catch (Exception $e) {
            if (App::get('config')['APP_ENV'] === 'dev') {
                $_SESSION['flash_message'] = "Erreur : " . $e->getMessage();
            } else {
                $_SESSION['flash_message'] = "Erreur lors de la suppression du compte.";
            }

            $_SESSION['flash_type'] = "error";

            error_log("User deletion error: " . $e->getMessage());
            Helper::redirect('user');
        }
    }

    private function registerError($msg){
        $nav = NavigationHelper::getNavigationButton();
        return Helper::view("user", [
            'title'   => 'Créer un compte',
            'message' => $msg,
            'type'    => "error",
            'btName'  => "Créer un compte",
            'btnLink' => 'login',
            'btnAbout' => $nav['btnAbout'],
            'btnAboutLink'   => $nav['btnAboutLink'],
            'user'    => (object)$_POST
        ], public: true);
    }

    private function updateError($msg, $user){
        $nav = NavigationHelper::getNavigationButton();
        return Helper::view("user", [
            'title'   => 'Modifier votre compte',
            'message' => $msg,
            'type'    => "error",
            'btName'  => "Mettre à jour",
            'btnLink' => 'list',
            'btnAbout' => $nav['btnAbout'],
            'btnAboutLink'   => $nav['btnAboutLink'],
            'user'    => $user
        ], public: true);
    }
}