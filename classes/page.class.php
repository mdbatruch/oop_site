<?php

    // namespace Front;

    class Page extends Database {
        private $title;
        public $content;
        public $url;
        static protected $table_name = 'pages';
        // static protected $connect;

        public function __construct($title, $content, $db) {
            $this->title = $title;
            $this->content = $content;

            $this->conn = $db;
            
            // self::$connect = $connect;

            // $pages = $site->find_all_pages();


            
        }

        public function __destruct() {
            // clean up here
        }

        public function render() {
            
            echo htmlspecialchars_decode($this->content);
            // echo $this->content;
        }

        // public function setContent($content) {
        //     $this->content = $content;
        // }

        public function setUrl($url) {
            $this->url = $url;
        }

        // public function find_all_pages() {
        //     $statement = $this->conn->prepare('SELECT * FROM ' . self::$table_name);
        //     $statement->execute();
        //     $pages = $statement->fetchAll(PDO::FETCH_ASSOC);
        //     return $pages;
        // }

        // public function render_nav() {
        //     // $page = self::find_all_pages();
        //     // foreach($page as $row) {
        //     //     echo $row['title'];
        //     // }
        //     echo 'bleh';
        // }
    }
?>