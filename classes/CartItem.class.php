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
        public function __construct($db){
            $this->conn = $db;
        }

        public function get_cart_id($user_id, $cart_id) {
            try {

                $stmt = $this->conn->prepare('SELECT * from cart_items WHERE cart_id = :cart_id' );
                $stmt->bindParam(":cart_id", $cart_id);
                $stmt->execute() or die(print_r($stmt->errorInfo(), true));

                $stmt->execute();

                $products_arr=array();

                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){

                    $row_decoded = json_decode($row['product']);

                    if(empty($row_decoded->image)) {
                        $row_decoded->image = 'Missing.jpg';
                    }

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
            $product_id = $products['id'];

            $stmt = $this->conn->prepare('SELECT * FROM cart_items WHERE product_id=:product_id AND cart_id=:cart_id');
            $stmt->bindValue(":product_id", $product_id);
            $stmt->bindValue(":cart_id", $cart_id);

            $stmt->execute() or die(print_r($stmt->errorInfo(), true));

            $rows = $stmt->fetch(PDO::FETCH_ASSOC);

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

            }

            echo json_encode($data);

        }

        public function increase($product_id, $cart_id, $quantity, $product = null) {
            $stmt = $this->conn->prepare('SELECT * FROM cart_items WHERE product_id=:product_id AND cart_id=:cart_id');
            $stmt->bindValue(":product_id", $product_id);
            $stmt->bindValue(":cart_id", $cart_id);

            $stmt->execute() or die(print_r($stmt->errorInfo(), true));

            $rows = $stmt->fetch(PDO::FETCH_ASSOC);

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

                    $stmt = $this->conn->prepare('INSERT INTO cart_items (product_id, product, quantity, cart_id) VALUES (?, ?, ?, ?)' );
                    
                    $stmt->bindParam(1, $product_id);
                    $stmt->bindParam(2, $product);
                    $stmt->bindParam(3, $quantity);
                    $stmt->bindParam(4, $cart_id);

                    $stmt->execute() or die(print_r($stmt->errorInfo(), true));

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

            $stmt = $this->conn->prepare('SELECT * FROM cart_items WHERE product_id=:product_id AND cart_id=:cart_id');
            $stmt->bindValue(":product_id", $product_id);
            $stmt->bindValue(":cart_id", $cart_id);

            $stmt->execute() or die(print_r($stmt->errorInfo(), true));

            $rows = $stmt->fetch(PDO::FETCH_ASSOC);

            $price_decode = json_decode($rows['product']);

            $new_quantity = $rows['quantity'] - 1;

            $price = substr($price_decode->price, 1) * $new_quantity;

            if (!empty($rows) && $rows['quantity'] > 0 && $new_quantity > 0) {

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
            }

            echo json_encode($data);

        }

        public function update($products, $user_id) {

            $stmt = $this->conn->prepare('SELECT products FROM cart_items WHERE user_id=:user_id');
            $stmt->bindParam(":user_id", $user_id);

            $stmt->execute() or die(print_r($stmt->errorInfo(), true));
            
            $rows = $stmt->fetch(PDO::FETCH_ASSOC);

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
                $stmt = $this->conn->prepare("SELECT * FROM carts WHERE user_id=:user_id");

                $stmt->bindParam(":user_id", $user_id);

                $stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);

                $stmt->execute();

                $rows = $stmt->fetch(PDO::FETCH_ASSOC);

                return $rows;

            } catch (Exception $e) {

                return $e->getMessage();
            }

        }

        public function exists($user_id){

            try {

                // prepare query statement
                $stmt = $this->conn->prepare("SELECT count(*) FROM cart_items WHERE user_id=:user_id");
            
                // bind category id variable
                $stmt->bindParam(":user_id", $user_id);
            
                // execute query
                $stmt->execute();
            
                // get row value
                $rows = $stmt->fetch(PDO::FETCH_NUM);
            
                // return
                if($rows[0]>0){
                    return true;
                }
            
                return false;

            } catch (Exception $e) {

                return $e->getMessage();
            }

        }

        static function clearCart($cart_id, $db) {
            try {

                $stmt = $db->prepare('DELETE FROM cart_items WHERE cart_id=:cart_id');
                $stmt->bindParam(":cart_id", $cart_id);
                $stmt->execute() or die(print_r($stmt->errorInfo(), true));

                } catch (Exception $e) {
    
                    return $e->getMessage();
                }
        }

    }
?>