<?php

    class Slider extends Database {

        static protected $table_name = 'galleries';

        public function __construct($db, $id) {
            $this->conn = $db;
            $this->id = $id;
        }

        public function insertGallery($title, $images) {

            $slides = [];

                foreach ($_FILES['gallery_images']['name'] as $key => $name) {

                $slides[] = $name;
            }

            $slides = json_encode($slides);

            try {

                $stmt = $db->prepare('INSERT INTO galleries (title, slides)
                                    VALUES (?, ?)');

                $stmt->bindParam(1, $title);
                $stmt->bindParam(2, $slides);

                $stmt->execute();

                $data['success'] = true;

                $data['message'] = 'Success! Gallery was created!';

            } catch (Exception $e) {
                        
                $data['success'] = false;

                $data['message'] = $e->getMessage();
            }

            echo json_encode($data);

        }

    }
