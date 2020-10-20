<?php

// require 'mail/PHPMailerAutoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'mail/Exception.php';
require 'mail/PHPMailer.php';
require 'mail/SMTP.php';

class Email {

    private $name;
    private $email;
    private $message;
    private $attachment;
    public $errors = [];
    public $data = [];

    public function __construct($name, $email, $attachment, $message){
        
        $this->name = $name;
        $this->email = $email;
        $this->message = $message;
        $this->attachment = $attachment;

        $smtp = parse_ini_file($_SERVER['DOCUMENT_ROOT'] . '/oop_site/.env/smtp.ini');

        $this->username = $smtp['username'];
        $this->password = $smtp['password'];
        $this->host = $smtp['host'];
        $this->port = $smtp['port'];
        $this->secure = $smtp['secure'];
        $this->recipient = $smtp['recipient'];
        $this->from = $smtp['from'];
    }

    public function validate() {

        $data = [];

        if (empty($this->name)) {
            $errors['name'] = "Name cannot be blank";
        }

        if (empty($this->email)) {
            $errors['email'] = "Email cannot be blank";
        } else if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = "Please enter a valid email";
        }

        if (empty($this->message)) {
            $errors['message'] = "Please enter a message";
        }

        if (!empty($errors)) {
            $data['notice'] = 'There was an error with your form. Please try again.';
            $data['success'] = false;
            $data['errors'] = $errors;
        } else {
            return true;
        }

        echo json_encode($data);
    }

    public function attach() {

        // add attachment validation here as well
        
        if (!empty($this->attachment) &&
        $this->attachment['error'] == UPLOAD_ERR_OK) {
            return true;
        }
    }

    public function Send(){

        $errors = [];

        if (!$this->validate()) {
            return false;
        } 

        try {
        

            $mail = new PHPMailer;

            $msg = "Name: " . $this->name . "<br/>";
            $msg .= "Email: " . $this->email . "<br/>";
            $msg .= "Message: " . $this->message;

            $this->attach();

            // var_dump($this->attachment);

            if ($this->attach()) {
                $mail->AddAttachment($this->attachment['tmp_name'],
                $this->attachment['name']);
            }

            // var_dump($this->attachment);


            $mail->IsSMTP();
            $mail->SMTPDebug = 0;
            $mail->Host = $this->host;
            // $mail->Host = 'dsadad';
            $mail->SMTPAuth = true;
            $mail->Username = $this->username;
            $mail->Password = $this->password;
            // $mail->Password = "Gff";
            $mail->SMTPSecure = $this->secure;
            $mail->Port = $this->port;
            $mail->From = $this->from;
            $mail->FromName = "ContactForm";
            $mail->AddAddress($this->recipient);
            $mail->AddReplyTo($this->email);
            $mail->isHTML(true);
            $mail->Subject = "New website message from: " . $this->name . " " . $this->email . " " . $this->message;
            $mail->Body = $msg;

                if (!$mail->Send()) {
                    $data['success'] = false;
                    $data['notice'] = 'There was a problem sending your form. Please contact me directly for further correspondence.';
                    $data['errors'] = $errors;
                } else {
                    $data['success'] = true;
                    $data['notice'] = "Success! Your Message has been sent. I will be in touch shortly.";
                }

            } catch (Exception $e) {
                echo 'Caught exception: ',  $e->getMessage(), "\n";

                $data['notice'] = 'Could not send at this time. Please try again.';
                $data['success'] = false;
            }

        echo json_encode($data);

    }

}

?>