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
                    
                    // echo '<pre>';
                    // print_r($row);

                    $row_decoded = json_decode($row['product']);

                    // echo '<pre>';
                    // print_r($row_decoded);

                    if(empty($row_decoded->image)) {
                        $row_decoded->image = 'Missing.jpg';
                    }

                    // echo $row_decoded->id;
                    extract($row);
              
                    $product_item=array(
                        "id" => $row_decoded->id,
                        "name" => $row_decoded->name,
                        "description" => html_entity_decode($row_decoded->description),
                        "image" => $row_decoded->image,
                        "price" => $row_decoded->price,
                        "quantity" => $row['quantity']
                    );
              
                    array_push($products_arr, $product_item);
                }

                return $products_arr;
    
                } catch (Exception $e) {
    
                    return $e->getMessage();
                }
        }

        public function getCartCount($cart_id, $user_id) {

            try {
                $stmt = $this->conn->prepare("SELECT * from cart_items WHERE cart_id=:cart_id");

                $stmt->bindParam(":cart_id", $cart_id);

                $stmt->execute();

                $count = 0;

                while ($rows = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $count += $rows['quantity'];
                }

                return $count;
            } catch (Exception $e) {
    
                return $e->getMessage();
            }
                
        }

        public function create($products, $user_id, $cart_id, $quantity) {

            // echo '<pre>';
            // print_r($products);

            $product_id = $products['id'];

            $stmt = $this->conn->prepare('SELECT * FROM cart_items WHERE product_id=:product_id AND cart_id=:cart_id');
            $stmt->bindValue(":product_id", $product_id);
            $stmt->bindValue(":cart_id", $cart_id);

            $stmt->execute() or die(print_r($stmt->errorInfo(), true));

            $rows = $stmt->fetch(PDO::FETCH_ASSOC);

            // echo '<pre>';
            // print_r($rows);

            if (!empty($rows)) {

                $quantity = $quantity + $rows['quantity'];

                $stmt = $this->conn->prepare('UPDATE cart_items SET quantity = :quantity WHERE product_id=:product_id AND cart_id=:cart_id');
                $stmt->bindValue(":quantity", $quantity);
                $stmt->bindValue(":product_id", $product_id);
                $stmt->bindValue(":cart_id", $cart_id);

                $stmt->execute() or die(print_r($stmt->errorInfo(), true));

                $data['quantity'] = $quantity;

                $data['success'] = true;
                
                $data['message'] = 'Success! Your Item has been updated!';

            } else {

                // $success = false;

            // if ($success) {

                $product = json_encode($products);

                try {

                $stmt = $this->conn->prepare('INSERT INTO cart_items (product_id, product, quantity, cart_id) VALUES (?, ?, ?, ?)' );
                $stmt->bindParam(1, $product_id);
                $stmt->bindParam(2, $product);
                $stmt->bindParam(3, $quantity);
                $stmt->bindParam(4, $cart_id);
                $stmt->execute() or die(print_r($stmt->errorInfo(), true));

                $data['success'] = true;
                
                $data['message'] = 'Success! Your Item has been added!';
                

                } catch (Exception $e) {

                    return $e->getMessage();

                    $data['success'] = false;
                    
                    $data['message'] = 'There was an issue!';

                }
            // }

            }

            echo json_encode($data);

        }

        public function increase($product_id, $cart_id, $quantity, $product = null) {
            $stmt = $this->conn->prepare('SELECT * FROM cart_items WHERE product_id=:product_id AND cart_id=:cart_id');
            $stmt->bindValue(":product_id", $product_id);
            $stmt->bindValue(":cart_id", $cart_id);

            $stmt->execute() or die(print_r($stmt->errorInfo(), true));

            $rows = $stmt->fetch(PDO::FETCH_ASSOC);

            // echo '<pre>';
            // print_r($rows);

            if (!empty($rows)) {

                $new_quantity = $rows['quantity'] + 1;

                $price_decode = json_decode($rows['product']);
            
                $price = substr($price_decode->price, 1) * $new_quantity;

                try {
                    $stmt = $this->conn->prepare('UPDATE cart_items SET quantity = :new_quantity WHERE product_id=:product_id AND cart_id=:cart_id');
                    $stmt->bindValue(":new_quantity", $new_quantity);
                    $stmt->bindValue(":product_id", $product_id);
                    $stmt->bindValue(":cart_id", $cart_id);

                    $stmt->execute() or die(print_r($stmt->errorInfo(), true));

                    $data['quantity'] = $new_quantity;
                    // $data['new_item'] = false;
                    $data['price'] = $price;

                    $data['id'] = $product_id;

                    $data['success'] = true;
                    
                    $data['message'] = 'Success! Your Cart has been updated!';

                } catch (Exception $e) {
            
                    return $e->getMessage();
    
                    $data['message'] = 'There was an error with your form. Please try again.';
    
                    $data['success'] = false;
    
                }

            } else {

                try {
                    
                    $product = json_encode($product);
                    // $new_quantity = $rows['quantity'] + 1;

                    $stmt = $this->conn->prepare('INSERT INTO cart_items (product_id, product, quantity, cart_id) VALUES (?, ?, ?, ?)' );
                    
                    $stmt->bindParam(1, $product_id);
                    $stmt->bindParam(2, $product);
                    $stmt->bindParam(3, $quantity);
                    $stmt->bindParam(4, $cart_id);

                    $stmt->execute() or die(print_r($stmt->errorInfo(), true));

                    // $data['quantity'] = $new_quantity;

                    // $data['new_item'] = true;

                    $data['id'] = $product_id;

                    $data['success'] = true;
                    
                    $data['message'] = 'Success! Your Item has been added to the cart!';

                } catch (Exception $e) {
            
                    return $e->getMessage();
    
                    $data['message'] = 'There was an error with your form. Please try again.';
    
                    $data['success'] = false;
    
                }

            }

            echo json_encode($data);

        }

        public function delete_cart_item($product_id, $cart_id) {

            try {

                $stmt = $this->conn->prepare('DELETE FROM cart_items WHERE product_id = ? AND cart_id = ? LIMIT 1' );
                $stmt->bindParam(1, $product_id);
                $stmt->bindParam(2, $cart_id);
                $stmt->execute() or die(print_r($stmt->errorInfo(), true));
    
                $data['id'] = $product_id;

                $data['success'] = true;
    
                $data['message'] = 'Success! Item has been removed!';
                
    
                } catch (Exception $e) {
    
                    return $e->getMessage();
    
                    $data['message'] = 'There was an error with your form. Please try again.';
    
                    $data['success'] = false;
    
                }

            echo json_encode($data);
        }

        public function delete($product_id, $cart_id, $quantity) {

            // echo $product_id . " " . $cart_id . " " . $quantity;

            $stmt = $this->conn->prepare('SELECT * FROM cart_items WHERE product_id=:product_id AND cart_id=:cart_id');
            $stmt->bindValue(":product_id", $product_id);
            $stmt->bindValue(":cart_id", $cart_id);

            $stmt->execute() or die(print_r($stmt->errorInfo(), true));

            $rows = $stmt->fetch(PDO::FETCH_ASSOC);

            // echo '<pre>';
            // print_r($rows);

            $price_decode = json_decode($rows['product']);

            // echo '<pre>';
            // print_r($price_decode);

            $new_quantity = $rows['quantity'] - 1;

            $price = substr($price_decode->price, 1) * $new_quantity;

            // echo $price;

            if (!empty($rows) && $rows['quantity'] > 0 && $new_quantity > 0) {

                // echo $quantity;

                // $new_quantity = $rows['quantity'] - 1;

                // echo '<br/>hello' . $new_quantity;

                $stmt = $this->conn->prepare('UPDATE cart_items SET quantity = :new_quantity WHERE product_id=:product_id AND cart_id=:cart_id');
                $stmt->bindValue(":new_quantity", $new_quantity);
                $stmt->bindValue(":product_id", $product_id);
                $stmt->bindValue(":cart_id", $cart_id);

                $stmt->execute() or die(print_r($stmt->errorInfo(), true));

                $data['quantity'] = $new_quantity;

                $data['price'] = $price;

                $data['id'] = $product_id;

                $data['success'] = true;
                
                $data['message'] = 'Success! Your Cart has been updated!';

            } else {
                // $success = false;

                // if ($success) {
                    try {

                        $stmt = $this->conn->prepare('DELETE FROM cart_items WHERE product_id = ? AND cart_id = ? LIMIT 1' );
                        $stmt->bindParam(1, $product_id);
                        $stmt->bindParam(2, $cart_id);
                        $stmt->execute() or die(print_r($stmt->errorInfo(), true));
            
                        $data['id'] = $product_id;
                        
                        $data['quantity'] = $new_quantity;

                        $data['success'] = true;
            
                        $data['message'] = 'Success! Item has been removed!';
                        
            
                        } catch (Exception $e) {
            
                            return $e->getMessage();
            
                            $data['message'] = 'There was an error with your form. Please try again.';
            
                            $data['success'] = false;
            
                        }
                // }   
            }

            echo json_encode($data);

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