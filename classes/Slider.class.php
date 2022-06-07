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
                // echo $name . '<br/>';

                // echo $key . '<br/>';

                //to make indexed
                // $slides[][$key] = $name;

                $slides[] = $name;
            }

            $slides = json_encode($slides);

            //  print_r($slides);

            //   for($i=0; $i<count($_FILES['gallery_images']); $i++) {

            //     $target_path = "uploads/";

            //     array_push($slides, $_FILES['gallery_images']['name']);

            //     $slides = json_encode($slides);

            //     // print_r($slides);

            //     // $ext = explode('.', basename( $_FILES['file']['gallery_images'][$i]));
            //     // $target_path = $target_path . md5(uniqid()) . "." . $ext[count($ext)-1]; 
            
            //     // if(move_uploaded_file($_FILES['file']['tmp_name'][$i], $target_path)) {
            //     //     echo "The file has been uploaded successfully <br />";
            //     // } else{
            //     //     echo "There was an error uploading the file, please try again! <br />";
            //     // }
            // }

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
