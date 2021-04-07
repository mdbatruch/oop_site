<?php
class Product{
  
    private $conn;
    private $table_name = "products";
  
    public $id;
    public $name;
    public $description;
    public $price;
    public $category_id;
    public $category_name;
    public $created;
  
    public function __construct($db){
        $this->conn = $db;
    }

    function read(){
 
        // select all products query
        $query = "SELECT
                    id, name, description, image, price, category_id 
                FROM
                    " . $this->table_name . "
                ORDER BY
                    created DESC";
     
        // prepare query statement
        $stmt = $this->conn->prepare( $query );
     
        // execute query
        $stmt->execute();
     
        // return values
        return $stmt;
    }

    public function create(){
    
        $stmt = $this->conn->prepare("INSERT INTO " . $this->table_name . " SET name=:name, price=:price, description=:description, category_id=:category_id, created=:created");
    
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":price", $this->price);
        $stmt->bindParam(":description", $this->description);
        $stmt->bindParam(":category_id", $this->category_id);
        $stmt->bindParam(":created", $this->created);
    
        if($stmt->execute()){
            return true;
        }
    
        return false;
        
    }

    public function readOne(){
 
        // query to select single record
        $query = "SELECT
                    id, name, description, image, price
                FROM
                    " . $this->table_name . "
                WHERE
                    name = ?
                LIMIT
                    0,1";
     
        // prepare query statement
        $stmt = $this->conn->prepare( $query );

        // sanitize
        // $this->id=htmlspecialchars(strip_tags($this->id));
        $this->name=htmlspecialchars(strip_tags($this->name));
     
        // bind product id value
        // $stmt->bindParam(1, $this->id);
        $stmt->bindParam(1, $this->name);
     
        // execute query
        $stmt->execute();
     
        // get row values
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
     
        $this->id = $row['id'];
        $this->name = $row['name'];
        $this->price = $row['price'];
        $this->image = $row['image'];
        $this->description = $row['description'];
        // $this->category_id = $row['category_id'];
        // $this->category_name = $row['category_name'];
    }

    public function getProduct($id){
 
        // query to select single record
        $query = "SELECT
                    id, name, description, image, price, category_id
                FROM
                    " . $this->table_name . "
                WHERE
                    id = ?
                LIMIT
                    0,1";
     
        // prepare query statement
        $stmt = $this->conn->prepare( $query );

        // sanitize
        $id=htmlspecialchars(strip_tags($id));
     
        // bind product id value
        $stmt->bindParam(1, $id);
     
        // execute query
        $stmt->execute();
     
        // get row values
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
     
        return $row;
    }

    public function update(){
  
        $stmt = $this->conn->prepare("UPDATE " . $this->table_name . " SET name = :name, price = :price, description = :description, category_id = :category_id WHERE id = :id");
      
        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':price', $this->price);
        $stmt->bindParam(':description', $this->description);
        $stmt->bindParam(':category_id', $this->category_id);
        $stmt->bindParam(':id', $this->id);
      
        if($stmt->execute()){
            return true;
        }
      
        return false;
    }

    public function delete(){
  
        $stmt = $this->conn->prepare("DELETE FROM " . $this->table_name . " WHERE id = ?");
      
        $this->id=htmlspecialchars(strip_tags($this->id));
      
        $stmt->bindParam(1, $this->id);
      
        if($stmt->execute()){
            return true;
        }
      
        return false;
    }

    public function search($keywords){
  
        $stmt = $this->conn->prepare("SELECT c.name as category_name, p.id, p.name, p.description, p.price, p.category_id, p.created FROM " . $this->table_name . " p LEFT JOIN categories c ON p.category_id = c.id WHERE p.name LIKE ? OR p.description LIKE ? OR c.name LIKE ? ORDER BY p.created DESC");
      
        $keywords=htmlspecialchars(strip_tags($keywords));
        $keywords = "%{$keywords}%";
      
        $stmt->bindParam(1, $keywords);
        $stmt->bindParam(2, $keywords);
        $stmt->bindParam(3, $keywords);
      
        $stmt->execute();
      
        return $stmt;
    }

    public function readPaging($from_record_num, $records_per_page){
  
        $stmt = $this->conn->prepare("SELECT c.name as category_name, p.id, p.name, p.description, p.price, p.category_id, p.created FROM " . $this->table_name . " p LEFT JOIN categories c ON p.category_id = c.id ORDER BY p.created DESC LIMIT ?, ?");
      
        $stmt->bindParam(1, $from_record_num, PDO::PARAM_INT);
        $stmt->bindParam(2, $records_per_page, PDO::PARAM_INT);
      
        $stmt->execute();
      
        return $stmt;
    }

    public function count(){
 
        // query to count all product records
        $query = "SELECT count(*) FROM " . $this->table_name;
     
        // prepare query statement
        $stmt = $this->conn->prepare( $query );
     
        // execute query
        $stmt->execute();
     
        // get row value
        $rows = $stmt->fetch(PDO::FETCH_NUM);
     
        // return count
        return $rows[0];
    }
}
?>