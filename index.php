<?php
// core.php holds pagination variables
include_once 'config/core.php';
  
// include database and object files
include_once 'config/Database.php';
include_once 'Controller/Product.php';
include_once 'Controller/Category.php';
  
// instantiate database and product object
$database = new Database();
$db = $database->getConnection();
  
$product = new Product($db);
$category = new Category($db);
  
$page_title = "Customer Index";
include_once "layouts/layout_header.php";

// include login checker
$check_loggin = true;
include_once "login_checker.php";

echo "<div class='col-md-12'>";

// to prevent undefined index notice
$action = isset($_GET['action']) ? $_GET['action'] : "";

// if login was successful
if ($action == 'login_success') {
    echo "<div class='alert alert-info'>";
    echo "<strong>Hi " . $_SESSION['firstname'] . ", ahihi đồ ngốc!</strong>";
    echo "</div>";
}

// if user is already logged in, shown when user tries to access the login page
else if ($action == 'already_logged_in') {
    echo "<div class='alert alert-info'>";
    echo "<strong>You are already logged in.</strong>";
    echo "</div>";
}
echo "</div>";
// content once logged in
$AllResult = $product->readAllReult();

// query products
$stmt = $product->readAll($from_record_num, $records_per_page);

// specify the page where paging is used
$page_url = "index.php?";

// count total rows - used for pagination
$total_rows = $product->countAll();

// read_template.php controls how the product list will be rendered
include_once "read_template.php";



  
// layout_footer.php holds our javascript and closing html tags
include_once "layouts/layout_footer.php";
?>