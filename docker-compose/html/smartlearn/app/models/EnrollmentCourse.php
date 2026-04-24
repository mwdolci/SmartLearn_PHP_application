<?php

/**
    * Représente une inscription enrichie avec les informations du cours,
    * de l'étudiant et des différents statuts liés à la progression.
    *
    * Cet objet est utilisé pour afficher une vue complète d'une inscription :
    * données du cours, informations de l'étudiant, et états des pastilles.
    *
    * --- Champs communs ---
    * @property int    $enrollment_id        Identifiant de l'inscription
    * @property int    $user_id              Identifiant de l'utilisateur inscrit
    * @property int    $course_id            Identifiant du cours
    * @property string $created_at           Date de création de l'inscription (format SQL)
    *
    * --- Champs du cours ---
    * @property string $name                 Nom du cours
    * @property string $descriptive          Description détaillée du cours
    * @property string $delay                Délai d'inscription (YYYY-MM-DD)
    * @property string $date_start           Date de début du cours (YYYY-MM-DD)
    * @property string $date_end             Date de fin du cours (YYYY-MM-DD)
    * @property string $time_start           Heure de début (HH:MM:SS)
    * @property string $time_end             Heure de fin (HH:MM:SS)
    * @property string $days                 Jour(s) du cours
    * @property int    $period               Nombre de crédits attribués
    * @property string $sites                Lieu où le cours est donné
    * @property float  $price                Prix du cours
    *
    * --- États des pastilles ---
    * @property string $inscription_status   État de l'inscription
    * @property string $admissibilite_status État de l'admissibilité
    * @property string $paiement_status      État du paiement
    * @property string $realisation_status   État de la réalisation du cours
    * @property string $certification_status État de la certification finale
    *
    * --- Champs spécifiques à la vue professeur ---
    * @property string $student_name         Nom de l'étudiant
    * @property string $student_forename     Prénom de l'étudiant
    * @property string $student_email        Email de l'étudiant
    *
    * @property string $teacher_name         Nom du professeur
    * @property string $teacher_forename     Prénom du professeur
*/
class EnrollmentCourse {

    // Champs communs
    public $enrollment_id;
    public $user_id;
    public $course_id;
    public $created_at;

    // Champs du cours
    public $name;
    public $descriptive;
    public $delay;
    public $date_start;
    public $date_end;
    public $time_start;
    public $time_end;
    public $days;
    public $period;
    public $sites;
    public $price;

    // États des pastilles
    public $inscription_status;
    public $admissibilite_status;
    public $paiement_status;
    public $realisation_status;
    public $certification_status;

    // Champs spécifiques à la vue professeur
    public $student_name;
    public $student_forename;
    public $student_email;

    public $teacher_name;
    public $teacher_forename;
}