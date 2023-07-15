<?php

require_once('Cart.class.php');

class Customer extends Cart {
  
    private $conn;
    private $table_name = "customers";
  
    public $id;
    public $name;
    public $description;
    public $created;
  
    public function __construct($db){
        $this->conn = $db;
    }

    public function create_customer($firstName, $lastName, $email, $address, $username, $password, $p_validate) {
        
        if (empty($address['street'])) {
            $errors['street'] = 'Street cannot be blank';
        }

        if (empty($address['city'])) {
            $errors['city'] = 'City cannot be blank';
        }

        if (empty($address['postal'])) {
            $errors['postal'] = 'Postal Code cannot be blank';
        }

        if (empty($address['province'])) {
            $errors['province'] = 'Province cannot be blank';
        }

        if (empty($address['country'])) {
            $errors['country'] = 'Country cannot be blank';
        }

        if (empty($firstName)) {
            $errors['firstname'] = 'First name cannot be blank';
          }

        if (empty($lastName)) {
            $errors['lastname'] = 'Last name cannot be blank';
        }

        $address = json_encode($address);

        if (empty($email)) {
            $errors['email'] = 'Email cannot be blank';
        } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = "Please enter a valid email";
        } else {

            $stmt = $this->conn->prepare("SELECT email from customers WHERE email = ?");
            $stmt->bindParam(1, $email);
            $stmt->execute();
            $email_exists = $stmt->fetchAll();

            if (!empty($email_exists)) {
                $errors['email'] = 'There is already an account associated with this email. Please contact the administrator for assistance with your account.';
            }

        }

        if (empty($username)) {
            $errors['username'] = 'Username cannot be blank';
        } else {

            $stmt = $this->conn->prepare("SELECT username from customers WHERE username = ?");
            $stmt->bindParam(1, $username);
            $stmt->execute();
            $username_exists = $stmt->fetchAll();

            if (!empty($username_exists)) {
                $errors['username'] = 'This username already exists, please try another one';
            }

        }

        if (empty($password)) {
            $errors['password'] = 'Password cannot be blank';
        } else if ($password !== $p_validate) {
            $errors['p_validate'] = 'Passwords do not match';
        } else {
            $password = password_hash($password, PASSWORD_DEFAULT);
        }

          if (!empty($errors)) {

            $data['message'] = 'There was an error with your submission. Please try again.';
            $data['success'] = false;
            $data['errors'] = $errors;

          } else {


                try {

                    $avatar = 'empty.png';

                    $stmt = $this->conn->prepare('INSERT INTO customers (first_name, last_name, email, avatar, address, username, hashed_password)
                                        VALUES (?, ?, ?, ?, ?, ?, ?)');
                    
                    $stmt->bindParam(1, $firstName);
                    $stmt->bindParam(2, $lastName);
                    $stmt->bindParam(3, $email);
                    $stmt->bindParam(4, $avatar);
                    $stmt->bindParam(5, $address);
                    $stmt->bindParam(6, $username);
                    $stmt->bindParam(7, $password);
        
                    $stmt->execute() or die(print_r($stmt->errorInfo(), true));

                    // get newly created customer id for creating cart and redirecting to account
                    $stmtId = $this->conn->prepare('SELECT id FROM customers WHERE username=:username');
                    $stmtId->bindParam(":username", $username);
                    $stmtId->execute();

                    $customerId = $stmtId->fetch(PDO::FETCH_ASSOC);

                    // create cart for customer
                    $cart = new Cart($this->conn);

                    $cart->createCart($customerId['id']);

                    $data['success'] = true;

                    session_regenerate_id();

                    $_SESSION['username'] = $username;
                    $_SESSION['id'] = $customerId['id'];
                    $_SESSION['account'] = 'Customer';
                    $_SESSION['last_login'] = time();
                    $_SESSION['avatar'] = $avatar;
                    $login_time = date('D-M-d-Y g:i A', $_SESSION['last_login']);

                    $data['redirect'] = 'private/customer/index.php?id=' . $customerId['id'];
        
                    $data['message'] = 'Success! Your Account was created!';
        
                } catch (Exception $e) {
                            
                    $data['success'] = false;
        
                    $data['message'] = $e->getMessage();
                }
          }

        echo json_encode($data);

    }

    public function login_customer($username, $password) {

        
        if (empty($username)) {
            $errors['username'] = 'Username cannot be blank';
          }

        if (empty($password)) {
            $errors['password'] = 'Password cannot be blank';
        }

        if (!empty($errors)) {

            $data['message'] = 'There was an error with your submission. Please try again.';
            $data['success'] = false;
            $data['errors'] = $errors;

          } else {


                try {

                    $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                    $stmt = $this->conn->prepare("SELECT id, avatar, username, hashed_password FROM customers WHERE username=:username");
                    
                    $stmt->bindParam(":username", $username);

                    $stmt->execute();

                    $customer_exists = $stmt->fetch(PDO::FETCH_ASSOC);

                    if (empty($customer_exists)) {
                        $data['success'] = false;
                        $data['errors'] = '';
                        $data['message'] = 'This account does not exist, please try again.';
                    } else if (!password_verify($password, $customer_exists['hashed_password'])) {
                        $data['success'] = false;
                        $data['errors'] = '';
                        $data['message'] = 'Invalid Username and/or password, please try again.';
                    } else {
                        //protects against session fixation attacks. Regenerates id everytime you log in.
                        session_regenerate_id();

                        $data['redirect'] = 'private/customer/index.php?id=' . $customer_exists['id'];
                        $data['success'] = true;
                        $data['message'] = 'Success! Logging into your account now.';

                        // set this instances' properties and session variables with the given values from the form submission and validation from database
                        $_SESSION['username'] = $customer_exists['username'];
                        $_SESSION['id'] = $customer_exists['id'];
                        $_SESSION['avatar'] = $customer_exists['avatar'];
                        $_SESSION['account'] = 'Customer';
                        $_SESSION['last_login'] = time();
                        $login_time = date('D-M-d-Y g:i A', $_SESSION['last_login']);


                        $_SESSION['orders'] = [];
                        
                        $orderCount = Order::fetchOrderCountById($customer_exists['id'], $this->conn);

                        $orders = Order::fetchOrders($customer_exists['id'], $orderCount, 0, $this->conn);

                        foreach($orders as $order) {
                            $_SESSION['orders'][] = $order['id'];
                        }

                    }
        
                } catch (Exception $e) {
                            
                    $data['success'] = false;
        
                    $data['message'] = $e->getMessage();
                }
                
          }
        
        echo json_encode($data);
    }

    static public function update($id, $firstName, $lastName, $username, $email, $address, $current_password, $new_password, $validate_password, $db) {

        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        if (empty($firstName)) {
            $errors['firstname'] = 'First name cannot be blank';
          }

        if (empty($lastName)) {
            $errors['lastname'] = 'Last name cannot be blank';
        }

        if (empty($email)) {
            $errors['email'] = 'Email cannot be blank';
        } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = "Please enter a valid email";
        } else {

            $stmt = $db->prepare("SELECT id, email from customers WHERE email = ?");
            $stmt->bindParam(1, $email);
            $stmt->execute();
            $email_exists = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!empty($email_exists)) {
                if ($email_exists['email'] == $email && !($email_exists['id'] == $id)) {
                    $errors['email'] = 'There is already an account associated with this email. Please contact the administrator for assistance with your account.';
                }
            }

        }

        if (empty($username)) {
            $errors['username'] = 'Username cannot be blank';
        } else {

            $stmt = $db->prepare("SELECT id, username from customers WHERE username = ?");
            $stmt->bindParam(1, $username);
            $stmt->execute();
            $username_exists = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!empty($username_exists)) {
                if ($username_exists['username'] == $username && !($username_exists['id'] == $id)) {
                    $errors['username'] = 'This username already exists, please try another one';
                }
            }
        }

        if (empty($address['street'])) {
            $errors['street'] = 'Street cannot be blank';
        }

        if (empty($address['city'])) {
            $errors['city'] = 'City cannot be blank';
        }

        if (empty($address['postal'])) {
            $errors['postal'] = 'Postal Code cannot be blank';
        }

        if (empty($address['province'])) {
            $errors['province'] = 'Province cannot be blank';
        }

        if (empty($address['country'])) {
            $errors['country'] = 'Country cannot be blank';
        }

        $address = json_encode($address);

        if ($current_password !== '') {

            $stmt = $db->prepare("SELECT hashed_password FROM customers WHERE username=:username");        
            $stmt->bindParam(":username", $username);

            $stmt->execute();

            $customer_exists = $stmt->fetch(PDO::FETCH_ASSOC);

                if (empty($current_password)) {
                    $errors['current_password'] = 'Password cannot be blank';
                } else if (!password_verify($current_password, $customer_exists['hashed_password'])) {
                    $errors['current_password'] = 'Your Password is incorrect';
                } else {
                    $current_password = password_hash($current_password, PASSWORD_DEFAULT);
               }

               if (empty($new_password)) {
                    $errors['validate_password'] = 'Password cannot be blank';
                } else if ($new_password !== $validate_password) {
                    $errors['validate_password'] = 'Passwords do not match';
                } else {
                    $new_password = password_hash($new_password, PASSWORD_DEFAULT);
                }

                if (!empty($errors)) {

                    $data['message'] = 'There was an error with your submission. Please try again.';
                    $data['success'] = false;
                    $data['errors'] = $errors;
        
                  } else {

                        try {
        
                            $stmt = $db->prepare('UPDATE customers SET first_name = ?, last_name = ?, username = ?, email = ?, address = ?, hashed_password = ? WHERE id = ?');
                            
                            $stmt->bindParam(1, $firstName);
                            $stmt->bindParam(2, $lastName);
                            $stmt->bindParam(3, $username);
                            $stmt->bindParam(4, $email);
                            $stmt->bindParam(5, $address);
                            $stmt->bindParam(6, $new_password);
                            $stmt->bindParam(7, $id);
                
                            $stmt->execute() or die(print_r($stmt->errorInfo(), true));
        
                            $_SESSION['username'] = $username;
        
                            $data['success'] = true;
        
                            $data['message'] = 'Success! Your Account was updated!';
                
                        } catch (Exception $e) {
                                    
                            $data['success'] = false;
                
                            $data['message'] = $e->getMessage();
                        }
                    }
                } else {

                if (!empty($errors)) {

                    $data['message'] = 'There was an error with your submission. Please try again.';
                    $data['success'] = false;
                    $data['errors'] = $errors;
        
                  } else {
        
                        try {
        
                            $stmt = $db->prepare('UPDATE customers SET first_name = ?, last_name = ?, username = ?, email = ?, address = ? WHERE id = ?');
                            
                            $stmt->bindParam(1, $firstName);
                            $stmt->bindParam(2, $lastName);
                            $stmt->bindParam(3, $username);
                            $stmt->bindParam(4, $email);
                            $stmt->bindParam(5, $address);
                            $stmt->bindParam(6, $id);
                
                            $stmt->execute() or die(print_r($stmt->errorInfo(), true));
        
                            $_SESSION['username'] = $username;
        
                            $data['success'] = true;
                            
                            $data['username'] = $username;
        
                            $data['message'] = '<span>Success!</span> Your Account was updated!';
                
                        } catch (Exception $e) {
                                    
                            $data['success'] = false;
                
                            $data['message'] = $e->getMessage();
                        }
                }

            }


        echo json_encode($data);

    }

    static public function view_customer_info($id, $db) {

        try {

        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $db->prepare("SELECT id, first_name, last_name, avatar, email, address, username, created_at FROM customers WHERE id=:id");
        $stmt->bindParam(":id", $id);

        $stmt->execute();

        $profile = $stmt->fetch(PDO::FETCH_ASSOC);

        return $profile;

        } catch (Exception $e) {
        
            return $e->getMessage();
        }
    }

    static public function fetchAllCustomers($db, $limit = null, $offset = null) {

        try {

            $customers = [];

            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $query = "SELECT *  FROM customers LIMIT " . $limit . " OFFSET " . $offset;

            $stmt = $db->prepare($query);

            $stmt->execute();

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                extract($row);

          
                $customer=array(
                    "id" => $row['id'],
                    "first_name" => $first_name,
                    "last_name" => $last_name,
                    "email" => $email,
                    "avatar" => $avatar,
                    "address" => $address,
                    "username" => $username,
                    "created_at" => $created_at
                );
          
                array_push($customers, $customer);
            }

            return $customers;

        } catch (Exception $e) {
        
            return $e->getMessage();
        }
    }

    static function fetchAllCustomersCount($db) {

        try {

            $stmt = $db->prepare('SELECT count(*) FROM customers');
            $stmt->execute() or die(print_r($stmt->errorInfo(), true));

            $rows = $stmt->fetch(PDO::FETCH_NUM);
        
            return $rows[0];

            } catch (Exception $e) {

                return $e->getMessage();
            }
    }
}
?>