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
  
if($product->delete()){
  
    http_response_code(200);
  
    echo json_encode(array("message" => "Product was deleted."));
}
  
else{
  
    http_response_code(503);
  
    echo json_encode(array("message" => "Unable to delete product."));
}
?>