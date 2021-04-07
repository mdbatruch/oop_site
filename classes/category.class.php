<?php
class Category{
  
    private $conn;
    private $table_name = "categories";
  
    public $id;
    public $name;
    public $description;
    public $created;
  
    public function __construct($db){
        $this->conn = $db;
    }
  
    static public function getCategories($db){

        try {

            $categories = [];

            $stmt = $db->prepare("SELECT id, name, description FROM categories");
            $stmt->execute();

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                extract($row);
          
                $category=array(
                    "id" => $id,
                    "name" => $name,
                    "description" => html_entity_decode($description)
                );
          
                array_push($categories, $category);
            }
      
            return $categories;

        } catch (Exception $e) {

            return $e->getMessage();

        }
    }

    static public function getProductcategories($productCategoryId, $categoryId) {
        
        try {

            $stmt = $db->prepare("SELECT name, description FROM categories INNER JOIN products ON product_category_id:product_category_id = category_id:category_id");

            $stmt->bindParam(":product_category_id", $productCategoryId);
            $stmt->bindParam(":category_id", $categoryId);

            $stmt->execute();

            // $row = $stmt->fetch(PDO::FETCH_ASSOC);
      
            return $stmt;

        } catch (Exception $e) {

            return $e->getMessage();

        }

    }

    public function read(){
  
        $query = "SELECT
                    id, name, description
                FROM
                    " . $this->table_name . "
                ORDER BY
                    name";
      
        $stmt = $this->conn->prepare( $query );
        $stmt->execute();
      
        return $stmt;
    }
}
?>