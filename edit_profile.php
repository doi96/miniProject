<?php

//Get user_id
$user_id = isset($_GET['user_id']) ? $_GET['user_id'] : die("User id not found!");
// echo $user_id;die;
// add config core
include_once 'config/core.php';
include_once 'config/Database.php';

$database = new Database();
$db = $database->getConnection();
//include class
include_once 'Controller/User.php';
$user = new User($db);
$user->id = $user_id;

//get profile user
$user->readProfile();

$page_title = 'User profile';

//include header layout
include_once 'layouts/layout_header.php';
?>
<?php
if ($_POST) {
    $user->firstname = $_POST['firstname'];
    $user->lastname = $_POST['lastname'];
    $user->address = $_POST['address'];
    $user->email = $_POST['email'];
    $user->contact_number = $_POST['contact_number'];
    // create the product
    if ($user->editProfile()) {
        echo "<div class='alert alert-success'>Your Profile was updated.</div>";
    }
    // if unable to create the category, tell the user
    else {
        echo "<div class='alert alert-danger'>Unable to updated profile.</div>";
    }
}
?>
<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])  . "?user_id={$user_id}" ?>" method="POST">
    <table class='table table-hover table-responsive table-bordered'>

        <tr>
            <td>USER ID</td>
            <td><?php echo htmlspecialchars($user->id); ?></td>
        </tr>
        <tr>
            <td> First Name</td>
            <td><input type='text' name='firstname' value="<?php echo htmlspecialchars($user->firstname); ?>" class='form-control' /></td>
        </tr>
        <tr>
            <td>Last Name</td>
            <td><input type='text' name='lastname' value="<?php echo htmlspecialchars($user->lastname); ?>" class='form-control' /></td>
        </tr>
        <tr>
            <td>Email</td>
            <td><input type='email' name='email' value="<?php echo htmlspecialchars($user->email); ?>" class='form-control' /></td>
        </tr>
        <tr>
            <td>Contact number</td>
            <td><input type='text' name='contact_number' value="<?php echo htmlspecialchars($user->contact_number); ?>" class='form-control' /></td>
        </tr>
        <tr>
            <td>Address</td>
            <td><input type='text' name='address' value="<?php echo htmlspecialchars($user->address); ?>" class='form-control' /></td>
        </tr>
        <tr>
            <td>Status</td>
            <?php if($user->status=='Active'){echo "<td><span style='color:green'> Active</span></td>";}else{
                echo "<td><span style='color:red'> Inctive</span></td>";} ?>
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

//layout footer
include_once 'layouts/layout_footer.php';

?>