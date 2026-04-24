<?php

require_once "core/Model.php";
require_once "app/models/EnrollmentCourse.php";

/**
 * Gestion des inscriptions aux cours.
 *
 * @property int $id         Identifiant de l'inscription
 * @property int $user_id    Identifiant de l'utilisateur inscrit
 * @property int $course_id  Identifiant du cours
 */
class Enrollment extends Model {
    public $id;
    public $user_id;
    public $course_id;

    /**
     * Récupère tous les cours auxquels un utilisateur est inscrit.
     */
    public static function getCoursesByUserId($user_id) {
        $dbh = App::get('dbh');
        $table = static::tableName();

        $stmt = $dbh->prepare("
            SELECT
                e.id AS enrollment_id,
                e.created_at,

                c.id AS course_id,
                c.name,
                c.descriptive,
                c.delay,
                c.date_start,
                c.date_end,
                c.time_start,
                c.time_end,
                c.days,
                c.period,
                c.sites,
                c.price,

                es.inscription_status,
                es.admissibilite_status,
                es.paiement_status,
                es.realisation_status,
                es.certification_status

            FROM $table e
            INNER JOIN course c ON c.id = e.course_id
            LEFT JOIN enrollmentstatus es ON es.id = e.id

            WHERE e.user_id = :user_id
            ORDER BY c.date_start ASC
        ");

        $stmt->execute(['user_id' => $user_id]);

        return $stmt->fetchAll(PDO::FETCH_CLASS, 'EnrollmentCourse');
    }

    /**
     * Récupère les étudiants inscrits aux cours d'un professeur.
     */
    public static function getStudentsForTeacher($teacher_id) {
        $dbh = App::get('dbh');
        $table = static::tableName();

        $stmt = $dbh->prepare("
            SELECT
                e.id AS enrollment_id,
                e.user_id,
                e.course_id,
                e.created_at,

                u.name AS student_name,
                u.forename AS student_forename,
                u.email AS student_email,

                c.name,
                c.sites,
                c.days,
                c.date_start,
                c.date_end,

                t.name AS teacher_name,
                t.forename AS teacher_forename,

                es.inscription_status,
                es.admissibilite_status,
                es.paiement_status,
                es.realisation_status,
                es.certification_status

            FROM $table e
            INNER JOIN user u ON u.id = e.user_id
            INNER JOIN course c ON c.id = e.course_id
            INNER JOIN user t ON t.id = c.teacher_id
            LEFT JOIN enrollmentstatus es ON es.id = e.id

            WHERE c.teacher_id = :teacher_id

            ORDER BY u.name ASC, u.forename ASC, c.date_start ASC, c.name ASC
        ");

        $stmt->execute(['teacher_id' => $teacher_id]);

        return $stmt->fetchAll(PDO::FETCH_CLASS, 'EnrollmentCourse');
    }

    /**
     * Vérifie qu'une inscription appartient à un cours du professeur.
     */
    public static function belongsToTeacher($enrollment_id, $teacher_id){
        $dbh = App::get('dbh');

        $sql = "SELECT COUNT(*)
                FROM enrollment
                JOIN course ON enrollment.course_id = course.id
                WHERE enrollment.id = ?
                AND course.teacher_id = ?";

        $stmt = $dbh->prepare($sql);
        $stmt->execute([$enrollment_id, $teacher_id]);

        return $stmt->fetchColumn() > 0;
    }
}