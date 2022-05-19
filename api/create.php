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

$product->name = $_GET['name'];
$product->price = $_GET['price'];
$product->description = $_GET['description'];
$product->image = $_GET['image'];
$product->category_id = $_GET['category_id'];
$product->created = date('Y-m-d H:i:s');

    if($product->create()){
  
        http_response_code(201);
  
        echo json_encode(array("message" => "Product was created."));
    }
  
    else{
  
        http_response_code(503);
  
        echo json_encode(array("message" => "Unable to create product."));
    }
?>