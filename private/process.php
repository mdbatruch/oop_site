<?php

    if ( $_SERVER['REQUEST_METHOD']=='GET' && realpath(__FILE__) == realpath( $_SERVER['SCRIPT_FILENAME'] ) ) {

      header( 'HTTP/1.0 403 Forbidden', TRUE, 403 );

      die( header( 'location: index.php' ) );
  }


    require('../initialize.php');

    $data = [];
    $errors = [];
    $id = $_POST['id'];

    global $connect;

  switch($id){
      case 'login':

        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';
      
        if (empty($username)) {
      
          $errors['username'] = 'Username cannot be blank';
      
        } else {
      
          $admin = $site::find_admin($username);
      
          if ($admin['username'] !== $username) {
            $errors['username'] = 'This username does not exist, man!';
          } else {
            if (empty($password)) {
      
              $errors['password'] = 'Password cannot be blank';
      
            } else {

                if (!password_verify($password, $admin['hashed_password'])) {
                    $errors['password'] = 'Incorrect Password';
                }
            }
          }
        }
      
        if (!empty($errors)) {
      
            $data['message'] = 'There was an error with your form. Please try again.';
            $data['success'] = false;
            $data['errors'] = $errors;
      
        } else {
      
          $data['redirect'] = 'private/index.php';
          $data['message'] = 'Logging you in now.';
          $data['success'] = true;
      

          // $session = new Session;

          $_SESSION['username'] = $admin['username'];
          $_SESSION['last_login'] = time();
          $login_time = date('D-M-d-Y g:i A', $_SESSION['last_login']);

          $session->login($admin['username'], $_SESSION['username'], $_SESSION['last_login']);

        }
      
      echo json_encode($data);
      
      break;

      case 'new-page':

        $name = $_POST['name'];
        $title = $_POST['title'];
        $subtitle = $_POST['subtitle'];
        $description = htmlspecialchars($_POST['description']);

        $site->insertPage($name, $title, $subtitle, $description);

      break;

      case 'edit-page':

        $page_id = $_POST['page_id'];
        $name = $_POST['name'];
        $title = $_POST['title'];
        $subtitle = $_POST['subtitle'];
        $description = $_POST['description'];

        $site->editPage($page_id, $name, $title, $subtitle, $description);

      break;

      case 'delete':

        $project_id = $_POST['project_id'];

        $site->deletePage($project_id);

      break;

      case 'contact':

        $name = $_POST['name'];
        $email = $_POST['email'];
        $message = $_POST['message'];

        // var_dump($attachment);

        if (!isset($_FILES['file'])) {
          $attachment = '';
        } else {
            $attachment = $_FILES['file'];
        }

        $email = new Email($name, $email, $attachment, $message);
        
        $email->Send();

      break;

    }

?>