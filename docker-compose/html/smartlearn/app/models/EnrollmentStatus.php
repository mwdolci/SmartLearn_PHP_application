<?php

require_once "core/Model.php";

/**
    * Représente l'état d'avancement d'une inscription à un cours.
    *
    * Chaque propriété correspond à une étape du parcours de l'étudiant :
    * inscription, admissibilité, paiement, réalisation et certification.
    * Les valeurs possibles sont généralement : "white", "green", "red".
    *
    * @property int    $id           Identifiant du statut d'inscription
    * @property string $inscription_status      État de l'inscription (demandée, validée, refusée)
    * @property string $admissibilite_status    État de l'admissibilité au cours
    * @property string $paiement_status         État du paiement du cours
    * @property string $realisation_status      État de la participation au cours
    * @property string $certification_status    État de la certification finale
*/
class EnrollmentStatus extends Model {
    public $id;
    public $inscription_status = 'green';
    public $admissibilite_status = 'white';
    public $paiement_status = 'white';
    public $realisation_status = 'white';
    public $certification_status = 'white';
}

