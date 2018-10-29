<?php

class Topic {

  const DB_TABLE = 'topic'; // database table name
  // database fields for this table
  public $topic_id = 0;
  public $topic = '';
  public $date_posted = '';
  public $number_posts = null;

  //Deletes a profile with a specific id
  public static function delete($topic_id) {
        $db = Db::instance(); // create db connection
        $q = sprintf("DELETE FROM topic WHERE `topic_id` = %d;",
          $topic_id
          );
        $result = $db->query($q); // execute query
  }

  // return a profile object by ID
  public static function getTopic($topic_id) {
      $db = Db::instance(); // create db connection
      // build query
      $q = sprintf("SELECT * FROM `%s` WHERE `topic_id` = %d;",
        self::DB_TABLE,
        $topic_id
        );
      $result = $db->query($q); // execute query
      if($result->num_rows == 0) {
        return null;
      } else {
        $row = $result->fetch_assoc(); // get results as associative array

        $topic = new Topic(); // instantiate
        $topic->topic_id   = $row['topic_id'];
        $topic->topic       = $row['topic'];
        $topic->date_posted     = $row['date_posted'];
        $topic->number_posts     = $row['number_posts'];

        return $topic; // return the member
      }
  }

  // return all Family Members in an array
  public static function getTopics() {
    $db = Db::instance();
    $q = "SELECT topic_id FROM `".self::DB_TABLE."`";
    $result = $db->query($q);

    $topics = array();
    if($result->num_rows != 0) {
      while($row = $result->fetch_assoc()) {
        $topics[] = self::getTopic($row['topic_id']);
      }
    }
    return $topics;
  }

  //Saves the new family member and adds them to the database
  public function save(){

    if($this->topic_id == 0) {
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
    $q = sprintf("INSERT INTO topic (`topic`, `date_posted`, `number_posts`)
    VALUES (%s, %s, %d);",
      $db->escape($this->topic),
      $db->escape($this->date_posted),
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
