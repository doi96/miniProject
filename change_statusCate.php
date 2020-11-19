<?php 
    // Get ID of product
    $id = isset($_GET['id']) ? $_GET['id'] : die("ERROR: ID not found!");
    
    // Include Database and Object
    include "config/Database.php";
    include "Controller/Category.php";

    // Data connecttion
    $database = new Database();
    $db = $database->getConnection();

    //prepare product object 
    $category = new Category($db);
    $category->id = $id;
// echo $product->id; die;

    $category->change_status();
    // echo "Product has been updated status successfully.";
    header('Location: view_category.php?');
