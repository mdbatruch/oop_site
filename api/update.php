<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
  
include_once '../classes/database.class.php';
include_once '../classes/product.class.php';

require('../initialize.php');
  
$database = new Database($site_path);
$db = $database->getConnection();
  
$product = new Product($db);

$product->id = isset($_GET['id']) ? $_GET['id'] : die();
$product->name = $_GET['name'];
$product->price = $_GET['price'];
$product->description = $_GET['description'];
$product->image = $_GET['image'];
$product->category_id = $_GET['category_id'];

// $data = json_decode(file_get_contents("php://input"));
  
// $product->id = $data->id;
  
// $product->name = $data->name;
// $product->price = $data->price;
// $product->description = $data->description;
// $product->category_id = $data->category_id;
  
if($product->update()){
  
    http_response_code(200);
  
    echo json_encode(array("message" => "Product was updated."));
}
  
else{
  
    http_response_code(503);
  
    echo json_encode(array("message" => "Unable to update product."));
}
?>