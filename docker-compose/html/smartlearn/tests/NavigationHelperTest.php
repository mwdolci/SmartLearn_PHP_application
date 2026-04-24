<?php

/**
 * Tests unitaires pour la classe NavigationHelper
 *
 * Lancer les tests :
 * 1. Se placer dans le conteneur Docker :
 *    docker-compose exec web bash
 *
 * 2. Aller dans le dossier du projet :
 *    cd /var/www/html/projet
 *
 * 3. Exécuter PHPUnit :
 *    vendor/bin/phpunit tests
 *
 * Résultat attendu :
 *    OK (2 tests, 4 assertions)
 *
 * Ces tests vérifient que le bouton de navigation affiche
 * le bon texte et le bon lien selon la page actuelle.
 */

use PHPUnit\Framework\TestCase; // Cette ligne permet d'utiliser la classe TestCase de PHPUnit pour créer des tests unitaires

require_once 'helpers/NavigationHelper.php';

class NavigationHelperTest extends TestCase // on étend la classe TestCase pour créer notre propre classe de test
{
    // Méthode est appelée avant chaque test pour réinitialiser l'environnement de test
    // Cette méthode appartient à PHPUnit et est utilisée pour s'assurer que chaque test est exécuté dans un environnement propre
    protected function setUp(): void 
    {
        $_SESSION = [];
        $_SERVER = [];
    }

    // Test 1 : sur la page "about"
    // Cette méthode teste le comportement de la fonction getNavigationButton() lorsque l'utilisateur est sur la page "about"
    // On simule la requête en définissant les variables d'environnement $_SERVER['REQUEST_URI'] et $_SERVER['HTTP_REFERER']
    // Ensuite, on appelle la fonction getNavigationButton() et on vérifie que le résultat correspond à ce qui est attendu (un bouton "Retour" avec un lien vers la page précédente)
    public function testRetourButton()
    {
        $_SERVER['REQUEST_URI'] = '/about';
        $_SERVER['HTTP_REFERER'] = '/list';

        $result = NavigationHelper::getNavigationButton();

        $this->assertSame('Retour', $result['btnAbout']); // Vérifie que le label du bouton est "Retour"
        $this->assertSame('/list', $result['btnAboutLink']); // Vérifie que le lien du bouton est "/list", ce qui correspond à la page précédente définie dans HTTP_REFERER
    }

    // Test 2 : pas sur "about"
    // Cette méthode teste le comportement de la fonction getNavigationButton() lorsque l'utilisateur n'est pas sur la page "about"
    // On simule la requête en définissant la variable d'environnement $_SERVER['REQUEST_URI'] à une autre valeur que "/about", par exemple "/list"
    // Ensuite, on appelle la fonction getNavigationButton() et on vérifie que le résultat correspond à ce qui est attendu (un bouton "A propos" avec un lien vers la page "about")
    public function testAboutButton()
    {
        $_SERVER['REQUEST_URI'] = '/list';

        $result = NavigationHelper::getNavigationButton();

        $this->assertSame('A propos', $result['btnAbout']); // Vérifie que le label du bouton est "A propos"
        $this->assertSame('about', $result['btnAboutLink']); // Vérifie que le lien du bouton est "about", ce qui correspond à la page "about" définie dans la fonction getNavigationButton() pour les autres pages que "/about"
    }
}