<?php
require_once "core/Model.php";

/**
    * Représente un cours disponible dans la plateforme SmartLearn.
    *
    * @property int    $id     Identifiant du cours
    * @property string $name          Nom du cours
    * @property string $descriptive   Description détaillée du cours
    * @property string $delay         Délai d'inscription (format date SQL)
    * @property string $date_start    Date de début du cours (YYYY-MM-DD)
    * @property string $date_end      Date de fin du cours (YYYY-MM-DD)
    * @property string $time_start    Heure de début du cours (HH:MM:SS)
    * @property string $time_end      Heure de fin du cours (HH:MM:SS)
    * @property string $days          Jours de la semaine où le cours est donné
    * @property int    $period        Nombre de crédits attribués
    * @property string $sites         Lieu où le cours est donné
    * @property float  $price         Prix du cours
    * @property int    $teacher_id    Identifiant du professeur responsable
*/
class Course extends Model {

    public $id;
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
    public $teacher_id;
}
