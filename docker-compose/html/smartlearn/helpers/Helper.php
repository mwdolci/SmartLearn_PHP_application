<?php

/**
 * Classe Helper
 * --------------
 * Cette classe regroupe des méthodes utilitaires utilisées à travers
 * toute l'application MVC. Elles ne font pas partie du modèle, ni des
 * vues, ni des contrôleurs : ce sont des outils transversaux.
 *
 * Toutes les méthodes sont statiques pour pouvoir être appelées
 * facilement depuis n'importe où : Helper::methode().
 */
class Helper {
    /**
        * Affiche proprement une variable (debug)
        *
        * @param mixed $data  Données à afficher
    */
    public static function display($data) {
        echo '<pre>';
        var_dump($data);
        echo '</pre>';
    }

    /**
        * dd = display & die
        * Affiche une variable puis arrête immédiatement l'exécution.
        * Très utile pour le débogage.
        *
        * @param mixed $data
    */
    public static function dd($data) {
        Helper::display($data);
        die();
    }

    /**
        * Charge une vue et l'injecte automatiquement dans le layout global.
        *
        * @param string $name  Nom de la vue (sans extension, ex: "list", "user", "about")
        * @param array  $data  Données à rendre disponibles dans la vue
    */
    public static function view(string $name, array $data = [], bool $public = false) {
        $config = App::get('config');
        extract($data);

        ob_start();
        require "app/views/{$name}.view.php";
        $content = ob_get_clean();

        if ($public) {
            require "app/views/partials/layout_public.php";
        } else {
            require "app/views/partials/layout_prive.php";
        }
    }

    /**
        * Redirige l'utilisateur vers une autre URL.
        *
        * @param string $path  Chemin interne (ex: 'login', 'cours/index')
        *
        * Attention : Chrome interprète mal les URL commençant par "//".
        * Le code gère un éventuel préfixe d'installation défini dans la config.
    */
    public static function redirect($path) {
		$prefix = App::get('config')['install_prefix'] ?? '';

		if (!empty($prefix)) {
			$path = $prefix . '/' . ltrim($path, '/');
		}

		header("Location: /" . ltrim($path, '/'));
		exit();
	}

    /**
        * Stocke un message dans la session.
        *
        * @param string $type  Nom de la clé (ex: 'error', 'success')
        * @param string $text  Message à stocker
        *
        * Utile pour les flash messages (ex: après un formulaire).
    */
    public static function session($type, $text) {
        $_SESSION[$type] = $text;
    }

    public static function e($value) {
        return htmlspecialchars($value ?? '', ENT_QUOTES, 'UTF-8');
    }

    public static function h($value) {
        return htmlentities($value ?? '', ENT_QUOTES, 'UTF-8');
    }
}