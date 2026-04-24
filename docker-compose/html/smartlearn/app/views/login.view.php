<form action="login-user" method="post" class="form-grid form-spacing">
    <label for="login_email">E-mail:</label>
    <input type="email" id="login_email" name="login_email">

    <label for="login_password">Mot de passe:</label>
    <input type="password" id="login_password" name="login_password">

    <input type="submit" value="Login" class="submit-btn">
</form>

<a class="btn-about" href="register">Créer un compte</a>

<?php if (!empty($message)): ?>
    <div class="alert alert-<?= $type ?>">
        <?= Helper::e($message) ?>
    </div>
<?php endif; ?>

<?php if (!empty($_SESSION['flash_message'])): ?>
    <div class="alert alert-<?= $_SESSION['flash_type'] ?>">
        <?= Helper::e($_SESSION['flash_message']) ?>
    </div>
    <?php unset($_SESSION['flash_message'], $_SESSION['flash_type']); ?>
<?php endif; ?>