<?php
    require_once 'header.php';

    $isAdmin = App::get('isAdmin');

    // Récupère l'URL actuelle
    $current = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
    
    // Si l'URL commence par le prefix, on le retire
    if (str_starts_with($current, $config['install_prefix'])) {
        $current = trim(substr($current, strlen($config['install_prefix'])), '/');
    }
?>

<main>
    <div>
        <div class="border header-user">
            <p class="textRight">
                <?php
                    $user = $_SESSION['user'] ?? null;
                    $icon = (!empty($user) && ($user['role'] ?? '') === 'teacher') ? '👨‍🏫' : '🧑‍🎓';
                ?>

                <?= $icon ?>
                <?= Helper::e(($user['forename'] ?? '') . ' ' . ($user['name'] ?? 'Invité')) ?>
            </p>

            <a class="btn-icon" href="user" title="configuration">
                <img src="<?= $config['FAVICON_PATH'] ?>wheel.png" alt="configuration">
            </a>

            <a class="btn-icon" href="logout" title="Logout">
                <img src="<?= $config['FAVICON_PATH'] ?>logout.png" alt="logout">
            </a>

        </div>
        <div class="box">
            <div class="sidebar border">
                
                <?php if ($isAdmin): ?>
                    <a class="<?= $current === 'create-course' ? 'active' : '' ?>"href="create-course">Créer un cours</a>
                <?php endif; ?>

                <a class="<?= $current === 'list' ? 'active' : '' ?>"
                   href="list">Liste des cours</a>

                <?php if (($user['role'] ?? '') === 'teacher'): ?>
                    <a class="<?= $current === 'student-progress' ? 'active' : '' ?>"
                    href="student-progress">Suivi étudiants</a>
                <?php else: ?>
                    <a class="<?= $current === 'my-courses' ? 'active' : '' ?>"
                    href="my-courses">Mes cours</a>
                <?php endif; ?>
            </div>

            <div class="content border">
                <?= $content ?>  <!-- Injectes le html capturé -->
            </div>
        </div>
    </div>

    <?php if (!empty($_SESSION['flash_message'])): ?>
        <div class="alert alert-<?= $_SESSION['flash_type'] ?>">
            <?= Helper::e($_SESSION['flash_message']) ?>
        </div>
        <?php unset($_SESSION['flash_message'], $_SESSION['flash_type']); ?>
    <?php endif; ?>
</main>

<?php require_once 'footer.php'; ?>