<?php

    class Session {

        private $admin_id;
        // public $account;
        public $username;
        public $id;
        private $last_login;

        public const MAX_LOGIN_AGE = 60 * 60 * 24;
        public const MAX_INACTIVITY = 300;

        public function __construct() {

            session_start();
            $this->check_stored_login();
        }

        public function login($admin, $username, $login_time) {
            if ($admin) {

                //protects against session fixation attacks. Regenerates id everytime you log in.
                session_regenerate_id();

                // set this instances' properties and session variables with the given values from the form submission and validation from database
                // $this->admin_id = $_SESSION['admin_id'] = $admin->id;
                $this->username = $username;
                $this->last_login = $login_time;
                $this->admin = true;
            }

            return true;
        }

        public function customer_login($username, $login_time, $customer) {

            //protects against session fixation attacks. Regenerates id everytime you log in.
            session_regenerate_id();

            // set this instances' properties and session variables with the given values from the form submission and validation from database
            $this->username = $username;
            $this->last_login = $login_time;
            $this->customer = $customer;

            return true;
        }


        public function is_logged_in_as_admin($account) {
            // returns true is there is and admin id and the last login was no too long ago
            // return isset($this->username) && $this->last_login_is_recent();
            // return isset($this->username);
            if ($account === 'Administrator') {
                return true;
            }
        }

        public function is_logged_in_as_customer($account) {
            
            // returns true is there is and admin id and the last login was no too long ago
            if ($account === 'Customer') {
                return true;
            }

            // if (isset($this->admin)){
            //     return true;
            // }
        }

        public function logout() {
            // unset($_SESSION['admin_id']);
            unset($_SESSION['username']);
            unset($_SESSION['account']);
            unset($_SESSION['last_login']);
            unset($this->username);
            unset($this->last_login);

            $_SESSION['logout_message'] = 'You have successfully logged out.';

            return true;
        }

        private function check_stored_login() {
            if (isset($_SESSION['username'])) {
                // $this->admin_id = $_SESSION['admin_id'];
                $this->username = $_SESSION['username'];
                $this->last_login = $_SESSION['last_login'];
            }
        }

        public function get_last_login() {
            return $this->last_login;
        }

        private function last_login_is_recent() {
            if (!isset($this->last_login)) {
                // if there's no login to begin with
                return false;
            // } elseif(($this->last_login + self::MAX_LOGIN_AGE) < time()) {
            } elseif(($_SERVER['REQUEST_TIME'] - $this->last_login) > self::MAX_LOGIN_AGE) {
                // if the last login time plus maximum allocated time for last login is less than current time
                $_SESSION['logout_message'] = 'We\'re sorry, but you have timed out. Please login again.';
                return false;
            } else {
                // it passed both previous tests so it is a recent login
                return true;
            }
        }

        public function message($msg="") {
            if (!empty($msg)) {
                // is a set message
                $_SESSION['message'] = $msg;
            } else {
                // is a get message
                return $_SESSION['message'] ?? '';
            }
        }

        public function clear_message() {
            unset($_SESSION['message']);
        }
    }

?>