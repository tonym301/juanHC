<?php

class Post {

  const DB_TABLE = 'posts'; // database table name
  // database fields for this table
  public $post_id = 0;
  public $description = '';
  public $date_posted = '';
  public $topic_id = null;
  public $profile_id = null;


  // return a profile object by ID
  public static function getPost($post_id) {
      $db = Db::instance(); // create db connection
      // build query
      $q = sprintf("SELECT * FROM `%s` WHERE `post_id` = %d;",
        self::DB_TABLE,
        $post_id
        );
      $result = $db->query($q); // execute query
      if($result->num_rows == 0) {
        return null;
      } else {
        $row = $result->fetch_assoc(); // get results as associative array

        $post = new Post(); // instantiate
        $post->post_id       = $row['post_id'];
        $post->description   = $row['description'];
        $post->date_posted   = $row['date_posted'];
        $post->topic_id      = $row['topic_id'];
        $post->profile_id    = $row['profile_id'];

        return $post; // return the member
      }
  }

  // return all Family Members in an array
  public static function getPosts($topic_id) {
    $db = Db::instance();
    $q = sprintf("SELECT * FROM `%s` WHERE `topic_id` = %d;",
      self::DB_TABLE,
      $topic_id
      );
    $result = $db->query($q);
    $posts = array();
    if($result->num_rows != 0) {
      while($row = $result->fetch_assoc()) {
        $posts[] = self::getPost($row['post_id']);
      }
    }
    return $posts;
  }

  //Saves the new family member and adds them to the database
  public function save($profile_id, $topic_id){
      return $this->insert($profile_id, $topic_id);
  }

  //Inserts the family member into the database
  public function insert($profile_id, $topic_id) {

    $db = Db::instance(); // connect to db

    $q = sprintf("UPDATE `topic` SET
    `number_posts`     = `number_posts` + 1
    WHERE `topic_id` = $topic_id");
    $db->query($q);

    $q1 = sprintf("UPDATE `profiles` SET
    `number_posts`     = `number_posts` + 1
    WHERE `profile_id` = $profile_id");
    $db->query($q1);

    $q2 = sprintf("INSERT INTO posts (`description`, `date_posted`, `topic_id`, `profile_id`)
    VALUES (%s, %s, %d, %d);",
      $db->escape($this->description),
      $db->escape($this->date_posted),
      $topic_id,
      $profile_id
      );

    $db->query($q2); // execute query
    return $db->getInsertID();
  }

}
