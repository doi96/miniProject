<?php

//Get ID category 
$id = isset($_GET['id']) ? $_GET['id'] : die("ERROR: ID not found!");
// echo $id;die;
//Include database
include_once "config/Database.php";
$database = new Database();
$db = $database->getConnection();

//Include Category object 
include_once "Controller/Category.php";
$category = new Category($db);
$category->id = $id;

//Get curent name of category
$category->readName();

//Include header layout
$page_title = "Edit category";
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
    if ($category->edit()) {
        echo "<div class='alert alert-success'>Category was updated.</div>";
    }
    // if unable to create the category, tell the user
    else {
        echo "<div class='alert alert-danger'>Unable to updated category.</div>";
    }
}
?>
<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])  . "?id={$id}" ?>" method="POST">
    <table class='table table-hover table-responsive table-bordered'>

        <tr>
            <td>ID</td>
            <td><?php echo htmlspecialchars($category->id); ?></td>
        </tr>
        <tr>
            <td>Name</td>
            <td><input type='text' name='name' value="<?php echo htmlspecialchars($category->name); ?>" class='form-control' /></td>
        </tr>
        <tr>
            <td>Status</td>
            <td><input type='checkbox' name='status' value='Active' <?php if ($category->status == 'Active') { echo 'checked';} ?> /> Active</td>
        </tr>

        <tr>
            <td></td>
            <td>
                <button type="submit" class="btn btn-primary">Update</button>
            </td>
        </tr>

    </table>
</form>
<?php
//Include booter layout
include_once "layouts/layout_footer.php";
?>