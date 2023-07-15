<?php

    class Page extends Database {
        private $title;
        public $content;
        public $url;
        public $homepage;
        static protected $table_name = 'pages';

        public function __construct($title, $content, $db) {
            $this->title = $title;
            $this->content = $content;

            $this->conn = $db;            
        }

        public function __destruct() {
            // clean up here
        }

        public function render() {
            
            echo htmlspecialchars_decode($this->content);
        }

        public function isHome() {
            if ($_GET['id'] == 1) {
                return true;
            }
        }

        public function setUrl($url) {
            $this->url = $url;
        }
    }
?>