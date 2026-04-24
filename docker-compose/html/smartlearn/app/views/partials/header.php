<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="author" content="Marco, Christophe">
        <meta name="description" content="SmartLearn – Gestion de cours et inscription des étudiants.">
        <meta name="keywords" content="cours, étudiants, inscription, SmartLearn">

        <!-- Open Graph / Social sharing -->
        <meta property="og:title" content="SmartLearn – Gestion de cours">
        <meta property="og:description" content="Gestion de cours et inscription des étudiants.">
        <meta property="og:type" content="website">

        <!-- Favicons classiques -->
        <link rel="icon" type="image/x-icon" href="<?= $config['FAVICON_PATH'] ?>favicon.ico">
        <link rel="icon" type="image/png" sizes="32x32" href="<?= $config['FAVICON_PATH'] ?>favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="16x16" href="<?= $config['FAVICON_PATH'] ?>favicon-16x16.png">

        <!-- Android / PWA -->
        <link rel="icon" type="image/png" sizes="192x192" href="<?= $config['FAVICON_PATH'] ?>android-chrome-192x192.png">
        <link rel="icon" type="image/png" sizes="512x512" href="<?= $config['FAVICON_PATH'] ?>android-chrome-512x512.png">

        <!-- Apple Touch Icon -->
        <link rel="apple-touch-icon" sizes="180x180" href="<?= $config['FAVICON_PATH'] ?>apple-touch-icon.png">

        <!-- Manifest PWA -->
        <link rel="manifest" href="<?= $config['FAVICON_PATH'] ?>site.webmanifest">

        <!-- Theme color -->
        <meta name="theme-color" content="#00c2ff">

        <!-- CSS -->
        <link rel="stylesheet"href="<?= $config['CSS_PATH'] ?>style.css">

        <!-- Titre de la page -->
        <title><?= Helper::e($title ?? "SmartLearn") ?></title>
        </head>
    <body>
    <header>
       <?php
            $btnAboutLink = $btnAboutLink ?? null;
            $btnAbout = $btnAbout ?? null;
        ?>

        <nav class="menu-right">
            <?php if ($btnAboutLink && $btnAbout): ?>
                <a class="btn-about" href="<?= Helper::e($btnAboutLink) ?>">
                    <?= Helper::e($btnAbout) ?>
                </a>
            <?php endif; ?>
        </nav>
        <h1><?= Helper::e($title ?? "SmartLearn") ?></h1>
    </header>
