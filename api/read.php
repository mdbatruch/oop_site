<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
  
include_once '../classes/database.class.php';
include_once '../classes/product.class.php';

require('../initialize.php');

error_reporting(E_ALL);
ini_set('display_errors', 1);
  
$database = new Database($site_path);
$db = $database->getConnection();
  
$product = new Product($db);
  
$stmt = $product->readAll();
$num = $stmt->rowCount();

if($num>0){
  
    $products_arr=array();
    $products_arr["records"]=array();
  
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);
  
        $product_item=array(
            "id" => $id,
            "name" => $name,
            "description" => html_entity_decode($description),
            "image" => $image,
            "price" => $price,
            "category_id" => $category_id
        );
  
        array_push($products_arr["records"], $product_item);
    }
  
    http_response_code(200);
  
    echo json_encode($products_arr, JSON_INVALID_UTF8_SUBSTITUTE);
    
} else{
  
    http_response_code(404);
  
    echo json_encode(
        array("message" => "No products found.")
    );
}