<?php
    class CartItem {
        private $conn;
        private static $table_name = "cart_items";

        public $id;
        public $product_id;
        public $quantity;
        public $user_id;
        public $created;
        public $modified;
        // public $products;

        public function __construct($db){
            $this->conn = $db;
        }

        public function get_cart_id($user_id, $cart_id) {
            try {

                $stmt = $this->conn->prepare('SELECT * from cart_items WHERE cart_id = :cart_id' );
                $stmt->bindParam(":cart_id", $cart_id);
                $stmt->execute() or die(print_r($stmt->errorInfo(), true));

                $stmt->execute();

                // $rows = $stmt->fetch(PDO::FETCH_ASSOC);

                // return $rows;

                $products_arr=array();

                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                    
                    // print_r(json_decode($row['product']));

                    $row_decoded = json_decode($row['product']);

                    // echo $row_decoded->id;
                    extract($row);
              
                    $product_item=array(
                        "id" => $row_decoded->id,
                        "name" => $row_decoded->name,
                        "description" => html_entity_decode($row_decoded->description),
                        "price" => $row_decoded->price
                    );
              
                    array_push($products_arr, $product_item);
                }

                return $products_arr;
    
                } catch (Exception $e) {
    
                    return $e->getMessage();
                }
        }

        public function create($products, $user_id, $cart_id) {

            // $products_col = [];

            

            // foreach ($products as $product) {
            //     $products_col[] = $product;
            // }

            // array_push($products_col, $products);

            // print_r($products);
            $product = json_encode($products);
            echo $product;


            try {

            $stmt = $this->conn->prepare('INSERT INTO cart_items (product, cart_id) VALUES (?, ?)' );
            $stmt->bindParam(1, $product);
            $stmt->bindParam(2, $cart_id);
            $stmt->execute() or die(print_r($stmt->errorInfo(), true));
            

            } catch (Exception $e) {

                return $e->getMessage();
            }

        }

        public function update($products, $user_id) {

            $stmt = $this->conn->prepare('SELECT products FROM cart_items WHERE user_id=:user_id');
            $stmt->bindParam(":user_id", $user_id);

            $stmt->execute() or die(print_r($stmt->errorInfo(), true));
            
            $rows = $stmt->fetch(PDO::FETCH_ASSOC);

            // $rows = $rows['products'];
            echo '<pre>';
            print_r($rows);

            // echo gettype($rows['products']);

            // $rows = json_encode($rows['products']);

            // print_r($rows);
            // print_r($products);

            // $object = (object) $products;

            // echo '<pre>';
            // print_r($rows);


            // $products = array_merge($rows, $products);
            // $products = json_encode($products);
            echo '<pre>';
            print_r($products);

            $test = array_map('array_merge', $rows, $products);

            echo '<pre>';
            print_r($test);

            // $rows["products"][] = $products;

            // $products_update = [];

            // $products_update = array_merge($products, $rows['products']);

            // echo '<pre>';
            // print_r($products_update);

            // $products_update = json_encode($products_update);

            // $products = json_encode($products);

            // echo '<pre>';
            // print_r($products_update);

            // foreach ($products as $product) {
            //     $products_col[] = $product;
            // }

            // $test = array_push($rows, $products);

            // $rows['products'][] = $products;

            // $rows = json_encode($products);

            // array_push($products_col, $rows);

            // $products_col = array_merge($products_col, $rows);

            // echo '<pre>';
            // print_r($rows);

            // echo '<pre>';
            // print_r($products_col);

            // echo $products;
            // echo '<pre>';
            // print_r($test);

            try {

            $stmt = $this->conn->prepare('UPDATE cart_items SET products = :products WHERE user_id = :user_id' );
            $stmt->bindValue(":products", $products);
            $stmt->bindValue(":user_id", $user_id);
            $stmt->execute() or die(print_r($stmt->errorInfo(), true));

            } catch (Exception $e) {

                return $e->getMessage();
            }

        }

        public function get_cart($user_id) {
            
            try {

                // $stmt = $this->conn->prepare("SELECT count(*) from cart_items WHERE user_id=:user_id");

                // $stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);

                // $stmt->execute();

                // $number_of_rows = $stmt->fetchColumn();

                // $number_of_rows = 1;

                // if ($number_of_rows > 0) {
                    
                    $stmt = $this->conn->prepare("SELECT * FROM carts WHERE user_id=:user_id");

                    $stmt->bindParam(":user_id", $user_id);

                    $stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);

                    // $stmt->execute() or die(print_r($stmt->errorInfo(), true));

                    $stmt->execute();

                    $rows = $stmt->fetch(PDO::FETCH_ASSOC);

                    return $rows;

                // } else {
                //     return false;
                //     // echo 'test';
                // }


            } catch (Exception $e) {

                return $e->getMessage();
            }

        }

        public function exists($user_id){

            try {

                // prepare query statement
                $stmt = $this->conn->prepare("SELECT count(*) FROM cart_items WHERE user_id=:user_id");
            
                // sanitize
                // $this->product_id=htmlspecialchars(strip_tags($this->product_id));
                // $this->user_id=htmlspecialchars(strip_tags($this->user_id));
            
                // bind category id variable
                $stmt->bindParam(":user_id", $user_id);
            
                // execute query
                $stmt->execute();
            
                // get row value
                $rows = $stmt->fetch(PDO::FETCH_NUM);
                // print_r($rows);
            
                // return
                if($rows[0]>0){
                    return true;
                }
            
                return false;

            } catch (Exception $e) {

                return $e->getMessage();
            }

        }

        // public function count(){
 
        //     // query to count existing cart item
        //     $query = "SELECT count(*) FROM " . $this->table_name . " WHERE user_id=:user_id";
         
        //     // prepare query statement
        //     $stmt = $this->conn->prepare( $query );
         
        //     // sanitize
        //     $this->user_id=htmlspecialchars(strip_tags($this->user_id));
         
        //     // bind category id variable
        //     $stmt->bindParam(":user_id", $this->user_id);
         
        //     // execute query
        //     $stmt->execute();
         
        //     // get row value
        //     $rows = $stmt->fetch(PDO::FETCH_NUM);
         
        //     // return
        //     return $rows[0];
        // }

    }
?>