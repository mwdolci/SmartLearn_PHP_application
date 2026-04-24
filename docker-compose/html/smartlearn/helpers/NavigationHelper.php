<?php
# helper/NavigationHelper.php
class NavigationHelper {
    public static function getNavigationButton() {
        $current = $_SERVER['REQUEST_URI'];

        //Si on est sur /about -> bouton Retour
        if(str_ends_with($current, 'about')) {

            //Mémoriser la page précédente si pas déjà fait
            if(!isset($_SESSION['previous_page'])) {
                $_SESSION['previous_page'] = $_SERVER['HTTP_REFERER'] ?? '/';
            }

            return[
                'btnAbout' => 'Retour',
                'btnAboutLink' => $_SESSION['previous_page'] ?? '/'
            ];
        }

        //Sinon -> bouton About
        return[
            'btnAbout' => 'A propos',
            'btnAboutLink' => 'about'
        ];
    }

}