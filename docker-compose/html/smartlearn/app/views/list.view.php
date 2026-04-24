<?php if (empty($courses)): ?>

    <div class="course-container">
        <p>Aucun cours disponible pour le moment.</p>
    </div>

<?php else: ?>

    <div class="course-container">

        <div class="course-list">
            <ul>
                <?php foreach ($courses as $index => $course): ?>
                    <li>
                        <label class="course-item">
                            <input
                                type="radio"
                                name="course"
                                value="<?= $course->id ?>"
                                <?= $index === 0 ? 'checked' : '' ?>
                                data-name="<?= Helper::e($course->name) ?>"
                                data-descriptive="<?= Helper::e($course->descriptive) ?>"
                                data-delay="<?= Helper::e($course->delay) ?>"
                                data-date-start="<?= Helper::e($course->date_start) ?>"
                                data-date-end="<?= Helper::e($course->date_end) ?>"
                                data-time-start="<?= Helper::e($course->time_start) ?>"
                                data-time-end="<?= Helper::e($course->time_end) ?>"
                                data-days="<?= Helper::e($course->days) ?>"
                                data-period="<?= Helper::e($course->period) ?>"
                                data-sites="<?= Helper::e($course->sites) ?>"
                                data-price="<?= Helper::e($course->price) ?>"
                            >
                            <span class="square"></span>
                            <span title="<?= Helper::e($course->name) ?>">
                                <?= Helper::e(mb_strimwidth($course->name, 0, 22, '...')) ?>
                            </span>
                        </label>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>

        <div class="course-details">

            <?php $firstCourse = $courses[0]; ?>

            <h3>Descriptif</h3>
            <p class="course-description" id="course-description">
                <?= nl2br(Helper::e($firstCourse->descriptive)) ?>
            </p>

            <h3>Informations</h3>

            <div class="course-info">
                <div class="info-col">
                    <p><strong>Délai d'inscription :</strong>
                        <span id="course-delay"><?= Helper::e($firstCourse->delay) ?></span>
                    </p>

                    <p><strong>Date de début :</strong>
                        <span id="course-date-start"><?= Helper::e($firstCourse->date_start) ?></span>
                    </p>

                    <p><strong>Date de fin :</strong>
                        <span id="course-date-end"><?= Helper::e($firstCourse->date_end) ?></span>
                    </p>

                    <p><strong>Jours :</strong>
                        <span id="course-days"><?= Helper::e($firstCourse->days) ?></span>
                    </p>
                </div>

                <div class="info-col">
                    <p><strong>Horaire :</strong>
                        <span id="course-time">
                            <?= date('H:i', strtotime($firstCourse->time_start)) ?>
                            -
                            <?= date('H:i', strtotime($firstCourse->time_end)) ?>
                        </span>
                    </p>

                    <p><strong>Périodes :</strong>
                        <span id="course-period"><?= Helper::e($firstCourse->period) ?></span>
                    </p>

                    <p><strong>Lieu :</strong>
                        <span id="course-sites"><?= Helper::e($firstCourse->sites) ?></span>
                    </p>

                    <p><strong>Prix :</strong>
                        <span id="course-price"><?= Helper::e($firstCourse->price) ?></span> CHF
                    </p>
                </div>
            </div>

        </div>
    </div>

    <div class="course-container">
        <form action="enroll-course" method="post">

            <input
                type="hidden"
                id="selected-course-id"
                name="course_id"
                value="<?= $courses[0]->id ?>"
            >

            <?php if (!$isAdmin): ?>
                <button type="submit" class="submit-btn">
                    Je m'inscris
                </button>
            <?php endif; ?>

        </form>
    </div>

<?php endif; ?>

<?php if (!empty($courses)): ?>
    <script src="public/js/course-details.js"></script>
<?php endif; ?>