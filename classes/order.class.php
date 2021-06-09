<?php

    class Order {

        private $conn;
        private static $table_name = "orders";

        public $id;
        public $order;
        public $created;

        public function __construct($db){
            $this->conn = $db;
        }

        public function createOrder($order) {

            // $profile = [];
            // $shipping_address = [];
            // $card_info = [];

            $id = $order['id'];

            $customer_id = $order['customer_id'];

            // $name = $order['contact_details']['name'];
            // $email  = $order['contact_details']['email'];
            // $phone = $order['contact_details']['phone'];
            // array_push($profile, $name, $email, $phone);
            // print_r($profile);

            // $street = $order['delivery_address']['street'];
            // $suite = $order['delivery_address']['suite'];
            // $city = $order['delivery_address']['city'];
            // $province = $order['delivery_address']['province'];
            // $postal = $order['delivery_address']['postal'];
            // array_push($shipping_address, $street, $suite, $city, $province, $postal);

            // $shipping_address = json_encode($shipping_address);
            // print_r($shipping_address);

            // $card_type = $order['card_details']['card_type'];
            // $card_hash = $order['card_details']['card_hash'];

            // array_push($card_info, $card_type, $card_hash);

            // print_r($card_info);

            $products = $order['order'];
            $products = json_encode($products);

            $contact = $order['contact_details'];
            $contact = json_encode($contact);

            $delivery_address = $order['delivery_address'];
            $delivery_address = json_encode($delivery_address);

            $card_details = $order['card_details'];
            $card_details = json_encode($card_details);

            $data = [];

            // echo '<pre>';
            // print_r($order);

            $amount = $order['amount'];

            try {

                $stmt = $this->conn->prepare('INSERT INTO orders (customer_id, contact_details, shipping_address, products, card_info, amount) VALUES (?,?,?,?,?,?)');
                $stmt->bindParam(1, $customer_id);
                $stmt->bindParam(2, $contact);
                $stmt->bindParam(3, $delivery_address);
                $stmt->bindParam(4, $products);
                $stmt->bindParam(5, $card_details);
                $stmt->bindParam(6, $amount);
                $stmt->execute() or die(print_r($stmt->errorInfo(), true));

                // get order id for success page
                $order = $this->conn->lastInsertId();

                $data['order'] = (int)$order;

                // echo 'The ID of the last inserted row was: ' . $order;
                // echo '<pre>';
                    // print_r($user_id);
                // Clear Cart Here
                $cart_id = Cart::getCartId($customer_id, $this->conn);


                CartItem::clearCart($cart_id['id'], $this->conn);

                // header("Location: ../confirmation.php", true, 301);


                // echo '<pre>';
                // print_r($order);
                echo json_encode($data['order']);

                } catch (Exception $e) {
    
                    return $e->getMessage();
                }
        }

        static function fetchOrderbyId($order, $db) {

            try {

                $orders = [];

                $stmt = $db->prepare('SELECT * FROM orders WHERE id = ?');
                $stmt->bindParam(1, $order);
                $stmt->execute() or die(print_r($stmt->errorInfo(), true));

                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                    extract($row);

                    // print_r($row);
              
                    $order_item=array(
                        "id" => $row['id'],
                        "customer_id" => $customer_id,
                        "contact_details" => $contact_details,
                        "shipping_address" => $shipping_address,
                        "products" => json_decode($products),
                        "card_info" => $card_info,
                        "amount" => $amount,
                        "created_at" => $created_at
                    );
              
                    array_push($orders, $order_item);
                }
              

                return $orders;

                } catch (Exception $e) {
    
                    return $e->getMessage();
                }

        }

        static function fetchOrders($order, $db) {

            try {

                $orders = [];

                $stmt = $db->prepare('SELECT * FROM orders WHERE customer_id = ?');
                $stmt->bindParam(1, $order);
                $stmt->execute() or die(print_r($stmt->errorInfo(), true));

                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                    extract($row);

                    // print_r($row);
              
                    $order_item=array(
                        "id" => $row['id'],
                        "customer_id" => $customer_id,
                        "contact_details" => $contact_details,
                        "shipping_address" => $shipping_address,
                        "products" => json_decode($products),
                        "card_info" => $card_info,
                        "amount" => $amount,
                        "created_at" => $created_at
                    );
              
                    array_push($orders, $order_item);
                }
              

                return $orders;

                } catch (Exception $e) {
    
                    return $e->getMessage();
                }

        }

        static function fetchAllOrders($db, $limit = null, $offset = null) {

            try {

                $orders = [];

                // $stmt = $db->prepare('SELECT * FROM orders');

                $query = "SELECT *  FROM orders LIMIT " . $limit . " OFFSET " . $offset;
                
                $stmt = $db->prepare($query);
                $stmt->execute() or die(print_r($stmt->errorInfo(), true));

                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                    extract($row);

                    // print_r($row);
              
                    $order_item=array(
                        "id" => $row['id'],
                        "customer_id" => $customer_id,
                        "contact_details" => $contact_details,
                        "shipping_address" => $shipping_address,
                        "products" => json_decode($products),
                        "card_info" => $card_info,
                        "amount" => $amount,
                        "created_at" => $created_at
                    );
              
                    array_push($orders, $order_item);
                }
              

                return $orders;

                } catch (Exception $e) {
    
                    return $e->getMessage();
                }

        }

        static function fetchAllOrdersCount($db) {

            try {

                $stmt = $db->prepare('SELECT count(*) FROM orders');
                $stmt->execute() or die(print_r($stmt->errorInfo(), true));

                $rows = $stmt->fetch(PDO::FETCH_NUM);
            
                return $rows[0];

                } catch (Exception $e) {
    
                    return $e->getMessage();
                }
        }

        

    }

?>