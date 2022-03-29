<?php

    if ( $_SERVER['REQUEST_METHOD']=='GET' && realpath(__FILE__) == realpath( $_SERVER['SCRIPT_FILENAME'] ) ) {

      header( 'HTTP/1.0 403 Forbidden', TRUE, 403 );

      die( header( 'location: index.php' ) );
  }


    require('../initialize.php');
    require_once('../init.php');

    $stripe = parse_ini_file($_SERVER['DOCUMENT_ROOT'] . $site_path . '/.env/stripe.ini');

    $data = [];
    $errors = [];
    $id = $_POST['id'];

    // print_r($_POST);

    global $connect;

  switch($id){
      case 'login':

        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';
      
        if (empty($username)) {
      
          $errors['username'] = 'Username cannot be blank';
      
        } else {
      
          $admin = $site->find_admin($username);

      // print_r($admin);
          if (empty($admin)) {
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
          $_SESSION['account'] = 'Administrator';
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

        $email = new Email($name, $email, $attachment, $message, $site_path);
        
        $email->Send();

      break;

      case 'new-gallery':

        $title = $_POST['gallery_title'];

        if ($_POST['gallery_assoc'] == 999) {
          $_POST['gallery_assoc'] = NULL;
        } else {

          $assoc = $_POST['gallery_assoc'];

        }

        $assoc = $_POST['gallery_assoc'];

        $description = $_POST['gallery_description'];

        $active = $_POST['gallery_active'];
  
        // var_dump($active);

        // exit;

        $slides = [];

        if (!empty($_FILES['gallery_images'])) {

          foreach ($_FILES['gallery_images']['name'] as $key => $name) {


            //to make indexed
            // $slides[][$key] = $name;

            $tmp_name = $_FILES['gallery_images']['tmp_name'][$key];

            $path = $_SERVER['DOCUMENT_ROOT'] . dirname(dirname($_SERVER['PHP_SELF'])) . '/uploads/';

            move_uploaded_file($tmp_name, $path . $name);

            $slides[] = $name;

          }
      }

       $slides = json_encode($slides);

      //  print_r($slides);

      //   for($i=0; $i<count($_FILES['gallery_images']); $i++) {

      //     $target_path = "uploads/";

      //     // print_r($slides);

      //     // $ext = explode('.', basename( $_FILES['file']['gallery_images'][$i]));
      //     // $target_path = $target_path . md5(uniqid()) . "." . $ext[count($ext)-1]; 
      
      //     // if(move_uploaded_file($_FILES['file']['tmp_name'][$i], $target_path)) {
      //     //     echo "The file has been uploaded successfully <br />";
      //     // } else{
      //     //     echo "There was an error uploading the file, please try again! <br />";
      //     // }
      // }

       $stmt = $db->prepare("SELECT title, id from galleries WHERE title = ?");
       $stmt->execute(array($title));
       $title_exists = $stmt->fetchAll(PDO::FETCH_ASSOC);

       $stmt2 = $db->prepare("SELECT page_id, id from galleries WHERE page_id = ?");
       $stmt2->execute(array($assoc));
       $assoc_exists = $stmt2->fetchAll();

        if ($title_exists){
            $errors['title'] = "This name already exists, please choose another one";
        }

        if ($assoc_exists && $assoc !== NULL){
            $errors['assoc'] = "This slider is already on another page, please choose another one";
        }

      if (empty($title)) {
        $errors['title'] = "Title can't be blank";
      }

      if (!empty($errors)) {
        
        $data['success'] = false;
        $data['message'] = 'There were errors. Please try again';
        $data['errors'] = $errors;

      } else {

          try {

            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $stmt = $db->prepare('INSERT INTO galleries (title, description, page_id, slides, active)
                                  VALUES (?, ?, ?, ?, ?)');

            $stmt->bindParam(1, $title);
            $stmt->bindParam(2, $description);
            $stmt->bindParam(3, $assoc);
            $stmt->bindParam(4, $slides);
            $stmt->bindParam(5, $active);

            $stmt->execute();

            // if ($stmt->execute()) {


              $data['success'] = true;

              $data['message'] = 'Success! Gallery was created!';
            // } else {
            //   print_r($db->errorInfo());
            // }

          } catch (PDOException $e) {
                    
              $data['success'] = false;

              $data['message'] = $e->getMessage();
          }
      }

      echo json_encode($data);

      break;

      case 'edit-gallery':

        $errors = [];

        $gallery_id = $_POST['gallery_id'];

        $title = $_POST['gallery_title'];

        $description = $_POST['gallery_description'];

        if ($_POST['gallery_assoc'] == 999) {
          $_POST['gallery_assoc'] = NULL;
        } else {

          $assoc = $_POST['gallery_assoc'];

        }

        $assoc = $_POST['gallery_assoc'];

        $active = $_POST['gallery_active'];


        // if ($_POST['gallery_active']) {
        // $active = 'Yes';
        // } else {
        //   $active = 'No';
        // }

        // var_dump($active);

        // exit;


        //add images to this
        $slides = [];

        $existing = $_POST['existing'];

        $existing = explode(',', $existing);

        foreach($existing as $exists) {
          $slides[] = $exists;
        }

        // print_r($slides);

        // exit;

        if (!empty($_FILES['gallery_images'])) {

            foreach ($_FILES['gallery_images']['name'] as $key => $name) {


              //to make indexed
              // $slides[][$key] = $name;

              $tmp_name = $_FILES['gallery_images']['tmp_name'][$key];

              $path = $_SERVER['DOCUMENT_ROOT'] . dirname(dirname($_SERVER['PHP_SELF'])) . '/uploads/';

              move_uploaded_file($tmp_name, $path . $name);

              $slides[] = $name;

          }
      }

      //  print_r($slides);

      //  exit;

       $slides = json_encode($slides);

       $stmt = $db->prepare("SELECT title, id from galleries WHERE title = ?");
       $stmt->execute(array($title));
       $title_exists = $stmt->fetchAll(PDO::FETCH_ASSOC);

       $stmt2 = $db->prepare("SELECT page_id, id from galleries WHERE page_id = ?");
       $stmt2->execute(array($assoc));
       $assoc_exists = $stmt2->fetchAll();


      // function to check if submitted gallery id exists in DB AND matches title from fetch from above
       function in_array_r($needle, $haystack, $strict = false) {
        foreach ($haystack as $item) {
            if (($strict ? $item === $needle : $item == $needle) || (is_array($item) && in_array_r($needle, $item, $strict))) {
                return true;
            }
        }
    
        return false;
    }

      $check_id = in_array_r($gallery_id, $title_exists) ? 'found' : 'not found';

      $check_assoc = in_array_r($gallery_id, $assoc_exists) ? 'found' : 'not found';

      //  echo $title_exists . '<br>';
      //  echo $assoc_exists . '<br>';
      // echo $gallery_id;
      //  print_r($assoc_exists);

       if ($title_exists && $check_id == 'not found'){
            $errors['title'] = "This name already exists, please choose another one";
        }

      if ($assoc_exists && $check_assoc == 'not found'){
          $errors['assoc'] = "This slider is already on another page, please choose another one";
      }


      if (empty($title)) {
          $errors['title'] = "Title can't be blank";
      }

      if (!empty($errors)) {
        
        $data['success'] = false;
        $data['message'] = 'There were errors. Please try again';
        $data['errors'] = $errors;

      } else {

        try {

          $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

          $stmt = $db->prepare("UPDATE galleries SET title = ?, description = ?, page_id = ?, slides = ?, active = ? WHERE id = ? LIMIT 1");
          // $stmt->bindParam("sisi", $title, $assoc, $slides, $gallery_id);
  
          $stmt->bindParam(1, $title);
          $stmt->bindParam(2, $description);
          $stmt->bindParam(3, $assoc);
          $stmt->bindParam(4, $slides);
          $stmt->bindParam(5, $active);
          $stmt->bindParam(6, $gallery_id);
  
          $stmt->execute();
  
          $data['success'] = true;
  
          $data['message'] = 'Success! Gallery was edited!';
  
        } catch (PDOException $e) {
                  
            $data['success'] = false;
  
            $data['message'] = $e->getMessage();
        }

      }

      echo json_encode($data);

      break;

      case 'confirm-delete-gallery':

        $gallery_id = $_POST['gallery_id'];

        $stmt = $db->prepare("DELETE FROM galleries WHERE id = ? LIMIT 1");
        $stmt->bindParam(1, $gallery_id);
        $stmt->execute();
        
        if ($stmt) {
          
            $data['success'] = true;
            $data['status'] = 'deleted';
            $data['message'] = 'Success! Your Gallery has been deleted!';
            $data['id'] = $gallery_id;
            
        } else {
            
            $data['message'] = 'We could not delete your gallery at this time';
        }
  
      echo json_encode($data);

      break;

      case 'save-navigation':

        // echo '<pre>';
        // print_r($_POST);

        // old

      //   $nav = $_POST['order'];

      //   try {
          
      //     $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

      //     $stmt = $db->prepare('UPDATE pages SET nav_order = ? WHERE page=?');

      //     foreach ($nav as $key => $value) {
      //         $stmt->bindValue(1, $value['order'], PDO::PARAM_INT);
      //         $stmt->bindValue(2, $value['page']);
      //         $stmt->execute();
      //     }

      //       $data['success'] = true;
      //       $data['message'] = 'Success! Your Nav has been edited!';


      //   } catch (PDOException $e) {
                  
      //     $data['success'] = false;

      //     $data['message'] = $e->getMessage();
      // }

      //old

         try {
          
          $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

          $stmt = $db->prepare('UPDATE navigations SET output = ? WHERE title=?');

            $stmt->bindValue(1, $_POST['output']);
            $stmt->bindValue(2, $_POST['title'], PDO::PARAM_STR);
            $stmt->execute();

            $data['success'] = true;
            $data['message'] = 'Success! Your Nav has been edited!';


        } catch (PDOException $e) {
                  
          $data['success'] = false;

          $data['message'] = $e->getMessage();

      }

      echo json_encode($data);

      break;

      case 'search':

        // echo '<pre>';
        // print_r($_POST);

        // exit;

        $search = new Search($db);

        try {
          
          $query = $search->search_term($_POST['term']);



          // $redirect = 'http://localhost:8888' . dirname(dirname($_SERVER['PHP_SELF'])) . '/search.php?search=' . $_POST['term'];
          // $redirect = root_url( 'search.php?search=' . $_POST['term']);

          if ($query) {
              header("Location: " . $redirect);
              exit;
          } else {
            echo 'No Results!';
          }

          // ajax
          // if ($query) {

          //   $data['success'] = true;

          //   $data['message'] = 'Here are your results';

          //   $data['redirect'] =  root_url( 'search.php?search=' . $_POST['term']);

          // } else {

          //   $data['success'] = false;

          //   $data['message'] = 'There is nothing available';

          //   $data['redirect'] =  root_url( 'search.php?search=' . $_POST['term']);

          // }

        } catch (PDOException $e) {


          // ajax
                  
          // $data['success'] = false;

          // $data['message'] = $e->getMessage();

          // $data['redirect'] =  root_url( 'search.php?search=' . $_POST['term']);

      }

      echo json_encode($data);

      break;

      case 'customer-register':

        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $email = $_POST['email'];
        $address = $_POST['address'];
        $username = $_POST['username'];
        $password = $_POST['password'];
        $p_validate = $_POST['p_validate'];

        $customer = new Customer($db);

        $customer->create_customer($firstname, $lastname, $email, $address, $username, $password, $p_validate);

      break;

      case 'customer-login':

        $username = $_POST['username'];
        $password = $_POST['password'];

        $customer = new Customer($db);

        $customer->login_customer($username, $password);

      break;

      case 'customer-update':

        // echo '<pre>';
        // print_r($_POST);

        $id = $_POST['customer_id'];
        $firstName = $_POST['first_name'];
        $lastName = $_POST['last_name'];
        $username = $_POST['username'];
        $email = $_POST['email'];

        Customer::update($id, $firstName, $lastName, $username, $email, $db);

      break;

      case 'add-cart':

        $user_id = $_POST['user_id'];
        $cart_id = $_POST['cart_id'];
        $product = $_POST['product'];
        $quantity = $_POST['quantity'];

        // print_r($_POST);

        $cart_item = new CartItem($db);

        // if ($cart_item->exists($user_id)) {
        //   $cart_item->update($product, $user_id);
        //   echo 'updated';
        // } else {
          $cart_item->create($product, $user_id, $cart_id, $quantity);
        //   echo 'created';
        // }

      break;

      case 'remove-item':

        $product_id = $_POST['product_id'];
        $cart_id = $_POST['cart_id'];
        $quantity = $_POST['quantity'];

        // echo '<pre>';
        // print_r($_POST);

        $cart_item = new CartItem($db);

        $cart_item->delete($product_id, $cart_id, $quantity);


      break;

      case 'add-item':

        $product_id = $_POST['product_id'];
        $cart_id = $_POST['cart_id'];
        $quantity = $_POST['quantity'];

        // echo '<pre>';
        // print_r($_POST);

        $cart_item = new CartItem($db);

        $cart_item->increase($product_id, $cart_id, $quantity);


      break;

      case 'remove-item-full':

        $product_id = $_POST['product_id'];
        $cart_id = $_POST['cart_id'];

        // echo '<pre>';
        // print_r($_POST);

        $cart_item = new CartItem($db);

        $cart_item->delete_cart_item($product_id, $cart_id);


      break;

      case 'add-cart-products':

        $product_id = $_POST['product']['id'];
        $product = $_POST['product'];
        $cart_id = $_POST['cart_id'];

        if (empty($_POST['quantity'])) {
          $quantity = 1;
        }

        // echo '<pre>';
        // print_r($_POST);

        $cart_item = new CartItem($db);

        $cart_item->increase($product_id, $cart_id, $quantity, $product);


      break;

      case 'order':

        $order = new Order($db, $stripe['secret_key']);

        $order->createOrder($_POST);

      break;

    }

?>