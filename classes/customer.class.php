<?php

class Customer {
  
    private $conn;
    private $table_name = "customers";
  
    public $id;
    public $name;
    public $description;
    public $created;
  
    public function __construct($db){
        $this->conn = $db;
    }

    public function create_customer($firstName, $lastName, $email, $address, $username, $password) {


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

            $stmt = $this->conn->prepare("SELECT email from customers WHERE email = ?");
            $stmt->bindParam(1, $email);
            $stmt->execute();
            $email_exists = $stmt->fetchAll();

            if (!empty($email_exists)) {
                $errors['email'] = 'There is already an account associated with this email. Please contact the administrator for assistance with your account.';
            }

        }

        if (empty($address)) {
            $errors['address'] = 'Address cannot be blank';
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
        } else {
            $password = password_hash($password, PASSWORD_DEFAULT);
        }

          if (!empty($errors)) {

            $data['message'] = 'There was an error with your submission. Please try again.';
            $data['success'] = false;
            $data['errors'] = $errors;

          } else {


                try {


                    $stmt = $this->conn->prepare('INSERT INTO customers (first_name, last_name, email, address, username, hashed_password)
                                        VALUES (?, ?, ?, ?, ?, ?)');
                    
                    $stmt->bindParam(1, $firstName);
                    $stmt->bindParam(2, $lastName);
                    $stmt->bindParam(3, $email);
                    $stmt->bindParam(4, $address);
                    $stmt->bindParam(5, $username);
                    $stmt->bindParam(6, $password);
        
                    $stmt->execute();
        
                    $data['success'] = true;
        
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

                    $stmt = $this->conn->prepare("SELECT id, username, hashed_password FROM customers WHERE username=:username");
                    
                    $stmt->bindParam(":username", $username);

                    $stmt->execute();

                    $customer_exists = $stmt->fetch(PDO::FETCH_ASSOC);

                    // print_r($customer_exists);

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

                        $data['redirect'] = 'private/customer/index.php?id=' . $customer_exists['id'];;
                        $data['success'] = true;
                        $data['message'] = 'Success! Logging into your account now.';

                        // set this instances' properties and session variables with the given values from the form submission and validation from database
                        $_SESSION['username'] = $customer_exists['username'];
                        $_SESSION['id'] = $customer_exists['id'];
                        $_SESSION['account'] = 'Customer';
                        $_SESSION['last_login'] = time();
                        $login_time = date('D-M-d-Y g:i A', $_SESSION['last_login']);

                    }
        
                } catch (Exception $e) {
                            
                    $data['success'] = false;
        
                    $data['message'] = $e->getMessage();
                }
                
          }
        
        echo json_encode($data);
    }

    static public function view_customer_info($id, $db) {

        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $db->prepare("SELECT id, first_name, last_name, address, username FROM customers WHERE id=:id");
        $stmt->bindParam(":id", $id);

        $stmt->execute();

        $profile = $stmt->fetch(PDO::FETCH_ASSOC);

        return $profile;
    }
}
?>