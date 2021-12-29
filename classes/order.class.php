<?php

    class Order {

        private $conn;
        private static $table_name = "orders";

        public $id;
        public $order;
        public $created;

        private $stripe_secret;

        public function __construct($db, $stripe){
            $this->conn = $db;
            $this->stripe_secret = $stripe;
        }

        public function createOrder($order) {

            $id = $order['id'];

            $customer_id = $order['customer_id'];

            $products = $order['order'];
            $products = json_encode($products);

            $contact = $order['contact_details'];
            $contact = json_encode($contact);

            $delivery_address = $order['delivery_address'];
            $delivery_address = json_encode($delivery_address);

            $billing_address = $order['billing_address'];
            $billing_address = json_encode($billing_address);

            $shipping_information = $order['shipping_information'];
            $shipping_information = json_encode($shipping_information);

            $card_details = $order['card_details'];
            $card_details = json_encode($card_details);

            $taxes_subtotals = $order['taxes_subtotals'];
            $taxes_subtotals = json_encode($taxes_subtotals);

            $amount = $order['amount'];
            $stripe_amount = ltrim($order['amount'], '$');

            $data = [];

            try {

                $stripe = new \Stripe\StripeClient(
                    $this->stripe_secret
                );

                // check if existing customer
                $exists = $stripe->customers->all(['email' => $order['contact_details']['email']]);

                // if no existing customer, then create a new customer 

                if (empty($exists['data'])) {
                
                  $stripe->customers->create([
                    'name' => $order['contact_details']['name'],
                    'email' => $order['contact_details']['email'],
                    'phone' => $order['contact_details']['phone'],
                    'address' => ['city' => $order['delivery_address']['city'], 'line1' => $order['delivery_address']['street'], 'postal_code' => $order['delivery_address']['postal'], 'state' => $order['delivery_address']['province']]
                  ]);

                  $name = $order['contact_details']['name'];

                } else {
                    $name = $exists['data'][0]['name'];
                }

                //remove decimal values from price
                $stripe_amount = str_replace('.', '', $stripe_amount);

                $stripe->charges->create([
                    'amount' => $stripe_amount,
                    'currency' => 'cad',
                    'source' => $order['token'],
                    // 'customer' => 'customer_id',
                    'description' => 'Order Charge for ' . $name,
                ]);


                //   $stripe->orders->create([
                //     'currency' => 'cad',
                //     'email' => $order['contact_details']['email'],
                //     'items' => [
                //       [
                //         'type' => 'sku',
                //         'parent' => 'price_1J64rIG2sTnL7IR6h0OijRys',
                //         'quantity' => '12',
                //         'amount' => '400'
                //       ],
                //     ],
                //     'shipping' => [
                //       'name' => $order['contact_details']['name'],
                //       'address' => [
                //         'line1' => $order['delivery_address']['street'],
                //         'city' => $order['delivery_address']['city'],
                //         'state' => $order['delivery_address']['province'],
                //         'country' => 'Canada',
                //         'postal_code' => $order['delivery_address']['postal'],
                //       ],
                //     ],
                //   ]);

                // exit;

                $stmt = $this->conn->prepare('INSERT INTO orders (customer_id, contact_details, shipping_address, billing_address, shipping_information, products, card_info, taxes_subtotals, amount) VALUES (?,?,?,?,?,?,?,?,?)');
                $stmt->bindParam(1, $customer_id);
                $stmt->bindParam(2, $contact);
                $stmt->bindParam(3, $delivery_address);
                $stmt->bindParam(4, $billing_address);
                $stmt->bindParam(5, $shipping_information);
                $stmt->bindParam(6, $products);
                $stmt->bindParam(7, $card_details);
                $stmt->bindParam(8, $taxes_subtotals);
                $stmt->bindParam(9, $amount);
                $stmt->execute() or die(print_r($stmt->errorInfo(), true));

                // get order id for success page
                $order = $this->conn->lastInsertId();

                $data['order'] = (int)$order;

                // Clear Cart Here
                $cart_id = Cart::getCartId($customer_id, $this->conn);

                CartItem::clearCart($cart_id['id'], $this->conn);

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
                        "billing_address" => $billing_address,
                        "shipping_information" => $shipping_information,
                        "products" => json_decode($products),
                        "card_info" => $card_info,
                        "taxes_subtotals" => $taxes_subtotals,
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

        static function fetchOrders($id, $limit = null, $offset = null, $db) {

            try {

                $orders = [];

                $query = "SELECT *  FROM orders WHERE customer_id = ? LIMIT " . $limit . " OFFSET " . $offset;

                $stmt = $db->prepare($query);
                $stmt->bindParam(1, $id);
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

        static function fetchOrderCountById($customer_id, $db) {

            try {

                $stmt = $db->prepare('SELECT count(*) FROM orders WHERE customer_id = ?');
                $stmt->bindParam(1, $customer_id);
                $stmt->execute() or die(print_r($stmt->errorInfo(), true));

                $rows = $stmt->fetch(PDO::FETCH_NUM);
            
                return $rows[0];

                } catch (Exception $e) {
    
                    return $e->getMessage();
                }
        }

        

    }

?>