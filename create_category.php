<?php

//include core
include_once 'config/core.php';
//Include database
include_once "config/Database.php";
$database = new Database();
$db = $database->getConnection();

//Include Category object 
include_once "Controller/Category.php";
$category = new Category($db);

//Include header layout
$page_title = "Add category";
include_once "layouts/layout_header.php";

// Read category button
echo "<div class='right-button-margin'> 
        <a href='view_category.php' class='btn btn-default pull-right'>Read Categories</a>
        </div>";

?>

<?php
if ($_POST) {
    $category->name = $_POST['name'];

    // create the product
    if ($category->create()) {
        echo "<div class='alert alert-success'>Category was created.</div>";
    }
    // if unable to create the category, tell the user
    else {
        echo "<div class='alert alert-danger'>Unable to create category.</div>";
    }
}
?>
<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="POST">
    <table class='table table-hover table-responsive table-bordered'>

        <tr>
            <td>Name</td>
            <td><input type='text' name='name' class='form-control' /></td>
        </tr>
        <tr>
            <td>Status</td>
            <td><input type='checkbox' name='status' value='Active' /> Active</td>
        </tr>
        <tr>
            <td></td>
            <td>
                <button type="submit" class="btn btn-primary">Create</button>
            </td>
        </tr>

    </table>
</form>
<?php
//Include booter layout
include_once "layouts/layout_footer.php";
?>