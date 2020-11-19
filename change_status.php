<?php 
    // Get ID of product
    $id = isset($_GET['id']) ? $_GET['id'] : die("ERROR: ID not found!");
    
    // Include Database and Object
    include "config/Database.php";
    include "Controller/Product.php";

    // Data connecttion
    $database = new Database();
    $db = $database->getConnection();

    //prepare product object 
    $product = new Product($db);
    $product->id = $id;
    // echo $product->id; die;
    
    $product->change_status();
    // echo "Product has been updated status successfully.";
    header('Location: index.php?');
    

?>