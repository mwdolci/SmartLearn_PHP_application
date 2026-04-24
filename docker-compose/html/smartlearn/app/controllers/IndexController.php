<?php

class IndexController {

    // affiche la page d'accueil du site
    public function index() {
        
        $nav = NavigationHelper::getNavigationButton();

        return Helper::view("index", [
            'title'    => 'Home',
            'btnAbout' => $nav['btnAbout'],
            'btnAboutLink'  => $nav['btnAboutLink']
        ], public: true);
    }
}