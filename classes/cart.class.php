<?php

    class Cart {

        private $conn;
        private static $table_name = "cart";

        public $id;
        public $user_id;
        public $created;

        public function __construct($db){
            $this->conn = $db;
        }

        public function createCart($user_id) {
            try {

                $stmt = $this->conn->prepare('INSERT INTO carts (user_id) VALUES (?)');
                $stmt->bindParam(1, $user_id);
                $stmt->execute() or die(print_r($stmt->errorInfo(), true));

                } catch (Exception $e) {
    
                    return $e->getMessage();
                }
        }

        static function getCartId($user_id, $db) {
            try {

                $stmt = $db->prepare('SELECT * FROM carts WHERE user_id=:user_id');
                $stmt->bindParam(":user_id", $user_id);
                $stmt->execute() or die(print_r($stmt->errorInfo(), true));

                $id = $stmt->fetch(PDO::FETCH_ASSOC);

                return $id;

                } catch (Exception $e) {
    
                    return $e->getMessage();
                }
        }

    }

?>