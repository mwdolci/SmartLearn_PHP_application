<?php
/**
* The Model class
*/
class Model {

   // L'idée derrière ces méthodes magiques __get et __set
   // est de pouvoir accéder à $object->attribute s'il existe un
   // attribut $attribute dans la classe, même s'il n'est pas public
   // ALTERNATIVES
   //    - rendre simplement tous les attributs publics, si aucun
   //      traitement actif n'est utile
   //    - utiliser la méthode __call pour émuler
   //      {get|set}CamelCaseAttribute -> $attribute
   // peut interférer avec les IDE proposant la saisie semi-automatique
   public function __get($attribute) {
      return $this->$attribute ?? null;
   }

   // Méthode magique appelée lorsqu’on tente d’affecter une valeur à un attribut inaccessible.
   // Vérifie que l’attribut existe réellement dans la classe avant de l’affecter, sinon lève une exception.
   //      (https://www.php.net/manual/en/function.property-exists.php)
   public function __set($attribute, $value) {
      if (property_exists($this, $attribute)) {
         $this->$attribute = $value;
      } else {
         throw new Exception("Propriété '$attribute' inexistante dans " . static::class);
      }
   }


   // Si votre classe dérivée ne respecte pas la convention de
   // configuration pour le nom de la table, redéfinissez cette
   // méthode de classe
   public static function tableName() {
      return strtolower(get_called_class());
   }

   // En général, pour les applications web, il est recommandé d'utiliser une clé primaire (PRIMARY KEY) systématique
   //, surtout si vous ne souhaitez pas mélanger
   // les identifiants externes (par exemple : une adresse e-mail, qui peut
   // changer) avec les identifiants internes (identifiants de substitution)
   // -- toutefois, si nécessaire, par exemple parce que votre base de données a été normalisée,
   //    il suffit de redéfinir cette méthode
   // BOGUES
   //    - ne prend pas en charge une clé primaire agrégée
   public static function primaryKeyName() {
      return "id";
   }


   public static function fetchAll() {
      $dbh = App::get('dbh');
      $statement = $dbh->prepare("SELECT * FROM " . static::tableName() . " ");
      $statement->execute();
      return $statement->fetchAll(PDO::FETCH_CLASS, get_called_class());
   }

    public static function fetchId($id) {
      // ASSUMPTION
      //    - $id was validated by the caller

      $dbh = App::get('dbh');

      // prepared statement with positionnal parameters
      $statement = $dbh->prepare("SELECT * FROM " . static::tableName() . " WHERE " . static::primaryKeyName() . " = ?");
      $statement->setFetchMode(PDO::FETCH_CLASS, get_called_class());
      $statement->execute([$id]);
      return $statement->fetch();
   }

   public static function placeholders($keys) {
      return array_map(function ($k) {
                        return ":" . $k;
                     },
                     $keys);
   }

   public static function placeholders_equals($keys) {
      return array_map(function ($k) {
                        return $k . " = :" . $k;
                     },
                     $keys);
   }

   public function update() {
      $dbh = App::get('dbh');

      $attributes = get_object_vars($this);
      $keys = $attributes;
      $keys = array_keys($keys);

      // prepared statement with question mark placeholders (marqueurs de positionnement)
      $req = "UPDATE "
            . static::tableName()
            . " SET " . join(", ", static::placeholders_equals($keys))
            . " WHERE (" . static::primaryKeyName() . " = :" . static::primaryKeyName() . ")";

      $statement = $dbh->prepare($req);
      // use exec() because no results are returned
      $statement->execute($attributes);
   }

   public function create() {
      $dbh = App::get('dbh');

      $attributes = get_object_vars($this);
      // if id is already set, assume we use it, else assume
      // it is auto-generated
      $id_exists = 0;
      if (array_key_exists(static::primaryKeyName(), $attributes)
         && isset($attributes[static::primaryKeyName()])) {
         $id_exists = 1;
      }

      // prepared statement with question mark placeholders (marqueurs de positionnement)
      $req = "INSERT INTO "
            . static::tableName()
            . " (" . join(", ", array_keys($attributes)) . ")"
            . " VALUES(" . join(", ", static::placeholders(array_keys($attributes))) . ")";

      $statement = $dbh->prepare($req);

      // use exec() because no results are returned
      $statement->execute($attributes);

      if (!$id_exists) {
         $id = static::primaryKeyName();
         $this->$id = $dbh->lastInsertId(); // indirect $id not id
      }
   }

    public function delete() {
      $dbh = App::get('dbh');

      $id = static::primaryKeyName();

      $statement = $dbh->prepare("DELETE FROM " . static::tableName()
                                 . " WHERE " . $id . " = ?");
      $statement->execute([$this->$id]);
   }

}