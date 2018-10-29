<?php

class Profile {

  const DB_TABLE = 'profiles'; // database table name
  // database fields for this table
  public $profile_id = 0;
  public $firstname = '';
  public $lastname = '';
  public $username = '';
  public $password = '';
  public $photo = null;
  public $number_posts = 0;

  //Deletes a profile with a specific id
  public static function delete($profile_id) {
        $db = Db::instance(); // create db connection
        $q = sprintf("DELETE FROM members WHERE `profile_id` = %d;",
          $profile_id
          );
        $result = $db->query($q); // execute query
  }

  // return a profile object by ID
  public static function getProfile($profile_id) {
      $db = Db::instance(); // create db connection
      // build query
      $q = sprintf("SELECT * FROM `%s` WHERE `profile_id` = %d;",
        self::DB_TABLE,
        $profile_id
        );
      $result = $db->query($q); // execute query
      if($result->num_rows == 0) {
        return null;
      } else {
        $row = $result->fetch_assoc(); // get results as associative array

        $profile = new Profile(); // instantiate
        $profile->profile_id   = $row['profile_id'];
        $profile->firstname    = $row['firstname'];
        $profile->lastname     = $row['lastname'];
        $profile->username     = $row['username'];
        $profile->password     = $row['password'];
        $profile->photo        = $row['photo'];
        $profile->number_posts = $row['number_posts'];

        return $profile; // return the member
      }
  }

  // return all Family Members in an array
  public static function getProfiles() {
    $db = Db::instance();
    $q = "SELECT * FROM `".self::DB_TABLE."`";
    $result = $db->query($q);

    $profiles = array();
    if($result->num_rows != 0) {
      while($row = $result->fetch_assoc()) {
        $profiles[] = self::getProfile($row['profile_id']);
      }
    }
    return $profiles;
  }

  //Saves the new family member and adds them to the database
  public function save($profile_id){
    if($profile_id == 0) {
      return $this->insert();
    }
    else {
      return $this->update();
    }
  }

  //Inserts the family member into the database
  public function insert() {
    if($this->topic_id != 0)
      return null;

    $db = Db::instance(); // connect to db
    $q = sprintf("INSERT INTO profiles (`firstname`, `lastname`, `username`, `password`, `photo`, `number_posts`)
    VALUES (%s, %s, %s, %s, %s, %d);",
      $db->escape($this->firstname),
      $db->escape($this->lastname),
      $db->escape($this->username),
      $db->escape($this->password),
      $db->escape($this->photo),
      $db->escape($this->number_posts)
      );

    $db->query($q); // execute query
    return $db->getInsertID();
  }

  //Updates specified data in the database
  public function update() {
    if($this->profile_id == 0)
      return null; // can't update something without an ID

    $db = Db::instance(); // connect to db
    $q = sprintf("UPDATE `profiles` SET
    `firstname` =   $db->escape($this->firstname),
    `lastname`  =   $db->escape($this->lastname),
    `username` =   $db->escape($this->username),
    `password` =   $db->escape($this->password),
    `photo`     =   $db->escape($this->photo),
    `number_posts`     = $db->escape($this->number_posts)
    WHERE `profile_id`     = $db->escape($this->profile_id);");

    $db->query($q); // execute query
    return $db->profile_id; // return this object's ID
  }

}
