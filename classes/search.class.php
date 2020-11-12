<?php

    class Search extends Database {

        public function __construct($db) {
            $this->conn = $db;
        }

        public function search_term($term) {

            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $stmt = $this->conn->prepare("SELECT page, title, subtitle, description from pages WHERE page LIKE :keywords OR title LIKE :keywords OR subtitle LIKE :keywords OR description LIKE :keywords");
            $stmt->bindValue(':keywords', '%' . $term . '%');
            $stmt->execute();

            $stuff = [];

            while ($result=$stmt->fetch(PDO::FETCH_ASSOC)) {

                $stuff[] = $result;
            }

            return $stuff;

        }

        public function render($queries) {

            if (empty($queries)) {
                echo '<h1>No Results!</h1>';
            } elseif (is_array($queries[0])) {

                foreach($queries as $query) {
                    echo '<h1>' . $query['page'] . '</h1>';
                    echo '<h3>' . $query['title'] . '</h3>';
                    echo '<h4>' . $query['subtitle'] . '</h4>';
                    echo '<p>' . $query['description'] . '</p>';

                }
            } else {

                echo '<h1>' . $queries[0] . '</h1>';
            } 
            
        }
    }

?>