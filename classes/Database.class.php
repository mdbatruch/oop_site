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

        private $site_path;

        public $errors = [];

        public function __construct($site_path) {
            $this->path = $site_path;
        }

        public function getConnection() {

            if ($_SERVER['SERVER_NAME'] == 'localhost') {
                $db = parse_ini_file($_SERVER['DOCUMENT_ROOT'] . $this->path . '/.env/db.ini');
            } else if ($_SERVER['SERVER_NAME'] == 'castlegames.mike-batruch.ca') {
                $db = parse_ini_file(dirname($_SERVER['DOCUMENT_ROOT']) . '/.env/db.ini');
            }
            
            $dsn = 'mysql:host=' . $db['server'] . ';dbname=' . $db['db'] . ';port=' . $db['port'];

            $this->conn = new PDO($dsn, $db['username'], $db['password']);

            return $this->conn;
        }

        public function find_all() {
            $statement = $this->conn->prepare('SELECT * FROM ' . static::$table_name);
            $statement->execute();
            $results = $statement->fetchAll(PDO::FETCH_ASSOC);
            return $results;
        }

        public function find_by_id($id) {

            try {

                $statement = $this->conn->prepare('SELECT * FROM ' . static::$table_name . ' where id=:id');
                $statement->bindParam(":id", $id);
                $statement->execute();
                $response = $statement->fetch(PDO::FETCH_ASSOC);

                return $response;

            } catch (Exception $e) {

                return $e->getMessage();
            }
        }
    }


?>