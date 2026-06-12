<?php

class userModel {
    private $db;

    function __construct() {
        $this->db = new PDO("mysql:host=".MYSQL_HOST .";dbname=".MYSQL_DB.";charset=utf8", MYSQL_USER, MYSQL_PASS);                
    }
    

    public function getByUser($user) {
        $query = $this->db->prepare('SELECT * FROM usuario WHERE email = ?');
        $query->execute([$user]);   
        $user = $query->fetch(PDO::FETCH_OBJ);

        return $user;
    }
}