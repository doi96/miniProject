<?php
// set page headers
// get ID of the product to be read
$id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: missing ID.');

//include core
include_once 'config/core.php';
// include database and object files
include_once 'config/Database.php';
include_once 'Controller/Product.php';
include_once 'Controller/Category.php';

// get database connection
$database = new Database();
$db = $database->getConnection();

// prepare objects
$product = new Product($db);
$category = new Category($db);

// set ID property of product to be read
$product->id = $id;

// read the details of product to be read
$product->readOne();
$page_title = "Read One Product";
include_once "layouts/layout_header.php";
  
// read products button
echo "<div class='right-button-margin'>";
    echo "<a href='index.php' class='btn btn-primary pull-right'>";
        echo "<span class='glyphicon glyphicon-list'></span> Read Products";
    echo "</a>";
echo "</div>";
// HTML table for displaying a product details
echo "<table class='table table-hover table-responsive table-bordered'>";
  
    echo "<tr>";
        echo "<td>Name</td>";
        echo "<td>{$product->name}</td>";
    echo "</tr>";
  
    echo "<tr>";
        echo "<td>Price</td>";
        echo "<td>".number_format($product->price) ." vnđ</td>";
    echo "</tr>";
  
    echo "<tr>";
        echo "<td>Description</td>";
        echo "<td>{$product->description}</td>";
    echo "</tr>";
  
    echo "<tr>";
        echo "<td>Category</td>";
        echo "<td>";
            // display category name
            $category->id=$product->category_id;
            $category->readName();
            echo $category->name;
        echo "</td>";
    echo "</tr>";

    echo "<tr>";
        echo "<td>Image</td>";
        echo "<td><img style='width:200px' src='uploads/images/$product->image' ></td>";
    echo "</tr>";

    echo "<tr>";
        echo "<td>Video</td>";
        if(!empty($product->video)){
            echo "<td><a target='_blank' href='uploads/videos/$product->video'>Watch video.</a></td>";
        }else{
        echo "<td></td>";
        }
    echo "</tr>";

    echo "<tr>";
        echo "<td>Status</td>";
        if ($product->status=='Active') {
        echo "<td><span style='color:green'>{$product->status}</span></td>";
        }else{
        echo "<td><span style='color:red'>{$product->status}</span></td>";

        }
        
    echo "</tr>";
  
echo "</table>";
  
// set footer
include_once "layouts/layout_footer.php";
?>