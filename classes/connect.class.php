<?php

    class Connect {

        // static protected $server;
        // static protected $user;
        // static protected $password;
        static protected $database;
        // static protected $port;
        // static protected $table_name =  "";
        // static protected $columns = [];
        // public $errors = [];

        static function set_database($database) {
            self::$database = $database;
        }

        // public function __construct($server, $user, $password, $database) {

        //     self::$server = $server;
        //     self::$user = $user;
        //     self::$password = $password;
        //     self::$database = $database;
        //     self::$port = 8889;
            
        //     try {
        //         $db = new PDO('mysql:host=' . self::$server . ';dbname=' . self::$database . ';port=' . self::$port, self::$user, self::$password);
        //         $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        //         $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        //         // echo "Connected successfully";
        //     } catch(PDOException $e) {
        //         echo "Connection failed: " . $e->getMessage();
        //     }
        // }

        // public function fetchAllPages() {
            
        //     try {

        //         $stmt = $db->prepare("SELECT id, page, title, subtitle FROM pages");
        //         $stmt->execute();
        //         $pages = $stmt->fetchAll(PDO::FETCH_ASSOC);
                
        //         return $pages;
            
        //     } catch(PDOException $e) {
        //         echo "Error: " . $e->getMessage();
        //     }
        // }

    }

?>