<div class="cours-container">
    <div class="suivi-colum">

        <?php if (!empty($courses)): ?>
            <?php foreach ($courses as $course): ?>
                <?php require 'partials/course_item.php'; ?>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="suivi-course">
                <p>Aucun cours inscrit pour le moment.</p>
            </div>
        <?php endif; ?>

    </div>
</div>
