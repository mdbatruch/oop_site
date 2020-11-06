<?php
    class Site {
        private $headers;
        private $footers;
        private $nav;
        private $page;
        private $conn;
        static protected $connect;

        public function __construct() {

            // $db = parse_ini_file($_SERVER['DOCUMENT_ROOT'] . dirname($_SERVER['PHP_SELF']) . '/.env/db.ini');
            $db = parse_ini_file($_SERVER['DOCUMENT_ROOT'] . '/oop_site/.env/db.ini');

            $dsn = 'mysql:host=' . $db['server'] . ';dbname=' . $db['db'] . ';port=8889';
            self::$connect = new PDO($dsn, 'root', 'root');

            // $this->conn = $db;

            // $pages = self::find_all_pages();

        }

        public function __destruct() {
            // clean up here
        }

        public function render() {
            $this->page->render();
        }

        public function addHeader() {
            require_once("includes/header.php");
        }

        public function addFooter() {
            require_once("includes/footer.php");
        }

        public function addNav() {
            $items = self::find_all_pages();

            $nav = [];

            echo '<ul class="navbar-nav">';
                foreach($items as $item) {
                    echo '<li class="nav-item">';
                        echo '<a class="nav-link" href="index.php?id=' . $item['id'] . '">' . $item['page'] . '</a>';
                    echo '</li>';
                }
            echo '</ul>';

        }

        public function addSlider() {
            require_once("includes/slider.php");
        }

        public function findSliderById($id) {
            $stmt = self::$connect->prepare('SELECT title, description, page_id, slides, active FROM galleries WHERE id=:id');
            $stmt->bindParam(":id", $id);
            $stmt->execute();
            $gallery = $stmt->fetch(PDO::FETCH_ASSOC);
            return $gallery;
        }

        public function findSliderByPageId($page_id) {
            $stmt = self::$connect->prepare('SELECT title, slides, active FROM galleries WHERE page_id=:page_id');
            $stmt->bindParam(":page_id", $page_id);
            $stmt->execute();
            $gallery = $stmt->fetch(PDO::FETCH_ASSOC);
            return $gallery;
        }

         static public function find_all_pages() {
            $statement = self::$connect->prepare('SELECT * FROM pages');
            $statement->execute();
            $pages = $statement->fetchAll(PDO::FETCH_ASSOC);
            return $pages;
        }

        static public function find_all_galleries() {
            $statement = self::$connect->prepare('SELECT * FROM galleries');
            $statement->execute();
            $pages = $statement->fetchAll(PDO::FETCH_ASSOC);
            return $pages;
        }

        static public function find_admin($username) {
            $statement = self::$connect->prepare('SELECT username, hashed_password FROM admins WHERE username=:username');
            $statement->bindParam(":username", $username);
            $statement->execute();
            $admin = $statement->fetch(PDO::FETCH_ASSOC);
            return $admin;
        }

        static public function find_by_id($id) {

            try {

                $statement = self::$connect->prepare('SELECT * FROM pages where id=:id');
                $statement->bindParam(":id", $id);
                $statement->execute();
                $response = $statement->fetch(PDO::FETCH_ASSOC);

                return $response;

            } catch (Exception $e) {

                return $e->getMessage();
            }
        }

        public function insertPage($name, $title, $subtitle, $description) {

            $stmt = self::$connect->prepare('SELECT page, title, subtitle, description from pages WHERE page=:page');
            $stmt->bindParam(':page', $name);
            $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            if($row) {
                $errors['name'] = 'This page name has already been taken, please choose another one.';
                
                $data['message'] = 'There was an error with your form. Please try again.';

                $data['success'] = false;
            }

            if (empty($name)) {
              $errors['name'] = 'Page name cannot be blank';
            }
    
            if (empty($title)) {
              $errors['title'] = 'Page title cannot be blank';
            }

            if (!empty($errors)) {

                $data['message'] = 'There was an error with your form. Please try again.';
                $data['success'] = false;
                $data['errors'] = $errors;
              } else {

                try {

                    $sql = self::$connect->prepare('INSERT INTO pages (page, title, subtitle, description)
                            VALUES (?, ?, ?, ?)');
        
                    $sql->bindParam(1, $name);
                    $sql->bindParam(2, $title);
                    $sql->bindParam(3, $subtitle);
                    $sql->bindParam(4, $description);

                    $sql->execute();

                    $page_path =  dirname(dirname($_SERVER['HTTP_REFERER'])) . '/pages/index.php';

                    $data['success'] = true;

                    $data['message'] = 'Success! Your Page was created!';

                    $data['redirect'] = $page_path;

                } catch (Exception $e) {
                
                    $data['success'] = false;
    
                    $data['message'] = $e->getMessage();
                }
            }

            echo json_encode($data);

        }

        public function editPage($id, $name, $title, $subtitle, $description) {

            $stmt = self::$connect->prepare('SELECT id, page, title, subtitle, description from pages WHERE page=:page');
            $stmt->bindParam(':page', $name);
            $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            // echo '<pre>';
            // print_r($row);
            // echo $id;

            if($row && $id !== $row['id']) {
                $errors['name'] = 'This page name has already been taken, please choose another one.';
                
                $data['message'] = 'There was an error with your form. Please try again.';

                $data['success'] = false;
            }

            if (empty($name)) {
                $errors['name'] = 'Page name cannot be blank';
              }
      
              if (empty($title)) {
                $errors['title'] = 'Page title cannot be blank';
              }
  
              if (!empty($errors)) {
  
                  $data['message'] = 'There was an error with your form. Please try again.';
                  $data['success'] = false;
                  $data['errors'] = $errors;
                } else {
  
                  try {
  
                      $stmt = self::$connect->prepare('UPDATE pages SET page = ?, title = ?, subtitle = ?, description = ? WHERE id=?');
          
                      $stmt->bindParam(1, $name);
                      $stmt->bindParam(2, $title);
                      $stmt->bindParam(3, $subtitle);
                      $stmt->bindParam(4, $description);
                      $stmt->bindParam(5, $id);
  
                      $stmt->execute();
  
                      $data['success'] = true;
  
                      $data['message'] = 'Success! Your Page was edited!';
  
                  } catch (Exception $e) {
                  
                      $data['success'] = false;
      
                      $data['message'] = $e->getMessage();
                  }
              }
  
              echo json_encode($data);
        }

        public function deletePage($id) {
    
            try {

                $stmt = self::$connect->prepare('DELETE FROM pages WHERE id=:id');
                $stmt->bindParam(':id', $id);
                $stmt->execute();

                if( ! $stmt->rowCount() ) {
                    $data['success'] = false;

                    $data['message'] = 'Deletion Failed, this page may be currently set to a Gallery which will need to be removed first.';
                } else {
                    $data['success'] = true;
                    $data['id'] = $id;
                    $data['message'] = 'Success! Page was deleted!';
                }

            } catch (Exception $e) {
            
                $data['success'] = false;

                $data['message'] = $e->getMessage();
            }

            echo json_encode($data);

        }

        public function setPage(Page $page) {
            $this->page = $page;
        }
    }
?>