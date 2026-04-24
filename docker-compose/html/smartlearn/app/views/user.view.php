<?php
    $user = $user ?? (object)[
        'name' => '',
        'forename' => '',
        'email' => '',
        'role' => ''
    ];
?>

<form action="<?= isset($user->id) ? 'update-user' : 'create-user' ?>" method="post" class="form-grid">

    <?php if (isset($user->id)): ?>
        <input type="hidden" name="user_id" value="<?= $user->id ?>">
    <?php endif; ?>

    <label for="name">Nom:</label>
    <input type="text" id="name" name="name"
            value="<?= Helper::e($user->name) ?>">

    <label for="forename">Prénom:</label>
    <input type="text" id="forename" name="forename"
            value="<?= Helper::e($user->forename) ?>">

    <label for="email">E-mail:</label>
    <input type="email" id="email" name="email"
            value="<?= Helper::e($user->email) ?>">

    <label for="password">Mot de passe:</label>
    <input type="password" id="password" name="password">

    <label for="confirmation">Confirmation:</label>
    <input type="password" id="confirmation" name="confirmation">

    <label for="role">Rôle:</label>
    <select id="role" name="role">
        <option value="student" <?= $user->role === 'student' ? 'selected' : '' ?>>Étudiant</option>
        <option value="teacher" <?= $user->role === 'teacher' ? 'selected' : '' ?>>Enseignant</option>
    </select>

    <input type="submit" value="<?= $btName ?>" class="submit-btn">

</form>

<?php if ($btName === 'Mettre à jour'): ?>
    <form action="delete-user" method="post" onsubmit="return confirm('Voulez-vous vraiment supprimer votre compte ?');">
        <button type="submit" class="btn-about">Supprimer le compte</button>
    </form>
<?php endif; ?>

<a class="btn-about" href="<?= Helper::e($btnLink ?? 'list') ?>">Retour</a>

<?php if (!empty($message)): ?>
    <div class="alert alert-<?= $type ?>">
        <?= Helper::e($message) ?>
    </div>
<?php endif; ?>