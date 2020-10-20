<?php 

    class Database {

        static protected $server;
        static protected $user;
        static protected $password;
        static protected $database;
        static protected $connect;
        static protected $port;
        static protected $table_name = "";
        static protected $columns = [];
        public $errors = [];

        public function __construct() {

            // $db = parse_ini_file($_SERVER['DOCUMENT_ROOT'] . dirname($_SERVER['PHP_SELF']) . '/.env/db.ini');
            
            // $db = parse_ini_file($_SERVER['DOCUMENT_ROOT'] . '/oop_site/.env/db.ini');

            // $dsn = 'mysql:host=' . $db['server'] . ';dbname=' . $db['db'] . ';port=8889';
            // $this->conn = new PDO($dsn, 'root', 'root');

            // return $this->conn;

            // $pages = self::find_all_pages();

        }

        public function getConnection() {
            $db = parse_ini_file($_SERVER['DOCUMENT_ROOT'] . '/oop_site/.env/db.ini');

            $dsn = 'mysql:host=' . $db['server'] . ';dbname=' . $db['db'] . ';port=8889';
            $this->conn = new PDO($dsn, 'root', 'root');

            return $this->conn;
        }

        // public function __construct($server, $user, $password, $database) {

        //     self::$server = $server;
        //     self::$user = $user;
        //     self::$password = $password;
        //     self::$database = $database;
        //     self::$port = 8889;
            
        //     try {
        //         $db = new mysqli(self::$server, self::$user, self::$password, self::$database, 8889);
        //     } catch(Exception $e) {
        //         echo "Connection failed: " . $e->getMessage();
        //     }
        // }

        // static public function set_database($database) {
        //     self::$database = $database;
        //   }

        // static public function find_by_sql($sql) {
        //     $result = self::$database->query($sql);
        //     if(!$result) {
        //         exit("Database query failed.");
        //     }
        
        //     // results into objects
        //     $object_array = [];
        //     while($record = $result->fetch_assoc()) {
        //         $object_array[] = static::instantiate($record);
        //     }
        
        //     $result->free();
        
        //     return $object_array;
        // }

        // static protected function instantiate($record) {
        //     $object = new static;
        //     // Could manually assign values to properties
        //     // but automatically assignment is easier and re-usable
        //     foreach($record as $property => $value) {
        //       if(property_exists($object, $property)) {
        //         $object->$property = $value;
        //       }
        //     }
        //     return $object;
        //   }
          
        // static public function find_all() {
        //     $sql = "SELECT id, page, title, subtitle, description FROM " . static::$table_name;

        //     $stmt = self::$database->prepare($sql);
        //     $stmt->execute();
        //     $pages = $stmt->fetchAll(PDO::FETCH_ASSOC);

        //     return $pages;
        // }

    }


?>