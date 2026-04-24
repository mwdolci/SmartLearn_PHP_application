<div class="cours-container">
    <div class="suivi-colum">

        <?php if (!empty($studentsCourses)): ?>

            <?php
            $currentStudent = null;

            foreach ($studentsCourses as $course):

                // Maintenant $course est un objet EnrollmentCourse
                $studentFullName = trim(($course->student_forename ?? '') . ' ' . ($course->student_name ?? ''));

                // Nouveau bloc étudiant
                if ($currentStudent !== $studentFullName):

                    // Ligne de séparation sauf pour le premier étudiant
                    if ($currentStudent !== null) {
                        echo '<hr class="student-separator">';
                    }

                    $currentStudent = $studentFullName;

                    echo '<div class="suivi-user">' . Helper::e($studentFullName) . '</div>';
                endif;
            ?>

                <?php
                // On passe directement l'objet au partial
                require 'partials/course_item.php';
                ?>

            <?php endforeach; ?>

        <?php else: ?>
            <p>Aucun étudiant inscrit pour le moment.</p>
        <?php endif; ?>

    </div>
</div>


<script src="<?= $config['JS_PATH'] ?>pastilles.js"></script>