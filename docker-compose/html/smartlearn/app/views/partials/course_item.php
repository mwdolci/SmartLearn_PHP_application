<?php
    $isAdmin = App::get('isAdmin');

?>

<div class="suivi-course">

    <div class="course-title">
        <?= Helper::e($course->name)?>
    </div>

    <div class="course-meta">
        <p><?= Helper::e($course->sites)?></p>
    </div>

    <div class="pastilles">

        <div class="pastille <?= $isAdmin ? 'clickable' : '' ?>"
            data-id="<?= Helper::e($course->enrollment_id) ?>"
            data-state="<?= Helper::e($course->inscription_status ?? 'white') ?>"
            data-name="inscription_status"
            title="Inscription"></div>

        <div class="pastille <?= $isAdmin ? 'clickable' : '' ?>"
            data-id="<?= Helper::e($course->enrollment_id) ?>"
            data-state="<?= Helper::e($course->admissibilite_status ?? 'white') ?>"
            data-name="admissibilite_status"
            title="Admissibilité"></div>

        <div class="pastille <?= $isAdmin ? 'clickable' : '' ?>"
            data-id="<?= Helper::e($course->enrollment_id) ?>"
            data-state="<?= Helper::e($course->paiement_status ?? 'white') ?>"
            data-name="paiement_status"
            title="Paiement"></div>

        <div class="pastille <?= $isAdmin ? 'clickable' : '' ?>"
            data-id="<?= Helper::e($course->enrollment_id) ?>"
            data-state="<?= Helper::e($course->realisation_status ?? 'white') ?>"
            data-name="realisation_status"
            title="Réalisation"></div>

        <div class="pastille <?= $isAdmin ? 'clickable' : '' ?>"
            data-id="<?= Helper::e($course->enrollment_id) ?>"
            data-state="<?= Helper::e($course->certification_status ?? 'white') ?>"
            data-name="certification_status"
            title="Certification"></div>

    </div>

</div>