<?php
require_once "core/Model.php";

/**
    * Représente un utilisateur de la plateforme SmartLearn.
    *
    * @property int    $id   Identifiant de l'utilisateur
    * @property string $email     Adresse email de l'utilisateur
    * @property string $name      Nom de l'utilisateur
    * @property string $forename  Prénom de l'utilisateur
    * @property string $password  Mot de passe hashé
    * @property string $role      Rôle de l'utilisateur (étudiant / professeur)
*/
class User extends Model {
    public $id;
    public $email;
    public $name;
    public $forename;
    public $password;
    public $role;

    /**
        * Recherche un utilisateur par son adresse email.
        *
        * @param string $email Adresse email recherchée
        * @return User|null Retourne l'utilisateur trouvé ou null si aucun résultat
    */
    public static function findByEmail($email) {
        $dbh = App::get('dbh');
        $table = static::tableName();
        $stmt = $dbh->prepare("SELECT * FROM $table WHERE email = ?");
        $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());
        $stmt->execute([$email]);
        return $stmt->fetch();
    }
}