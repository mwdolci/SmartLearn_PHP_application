<?php
# app/controllers/AboutController.php

class AboutController {

    // affiche la page à propos du site
    public function index() {

        $nav = NavigationHelper::getNavigationButton();

        Helper::view('about', [
            'title' => 'À propos de SmartLearn',
            'btnAbout' => $nav['btnAbout'],
            'btnAboutLink' => $nav['btnAboutLink']
        ], public: true);
    }
}
