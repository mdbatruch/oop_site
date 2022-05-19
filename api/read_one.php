<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');
  
include_once '../classes/database.class.php';
include_once '../classes/product.class.php';

require('../initialize.php');

 error_reporting(E_ALL);
    ini_set('display_errors', 1);
  
  
$database = new Database($site_path);
$db = $database->getConnection();
  
$product = new Product($db);

$product->name = isset($_GET['name']) ? $_GET['name'] : die();
  
$product->readOne();
  
if($product->name!=null){

    $product_arr = array(
        "id" =>  $product->id,
        "name" => $product->name,
        "description" => $product->description,
        "price" => $product->price,
        "image" => $product->image,
        "category_id" => $product->category_id,
        "category_name" => $product->category_name
  
    );
  
    http_response_code(200);
  
    echo json_encode($product_arr);
}
  
else{
    http_response_code(404);
  
    echo json_encode(array("message" => "Product does not exist."));
}
?>