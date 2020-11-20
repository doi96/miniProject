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

<table class='table table-hover table-responsive table-bordered'>

    <tr>
        <td>USER ID</td>
        <td><?php echo htmlspecialchars($user->id); ?></td>
    </tr>
    <tr>
        <td> First Name</td>
        <td><?php echo htmlspecialchars($user->firstname); ?></td>
    </tr>
    <tr>
        <td>Last Name</td>
        <td><?php echo htmlspecialchars($user->lastname); ?></td>
    </tr>
    <tr>
        <td>Email</td>
        <td><?php echo htmlspecialchars($user->email); ?></td>
    </tr>
    <tr>
        <td>Contact number</td>
        <td><?php echo htmlspecialchars($user->contact_number); ?></td>
    </tr>
    <tr>
        <td>Address</td>
        <td><?php echo htmlspecialchars($user->address); ?></td>
    </tr>
    <tr>
        <td>Status</td>
        <?php if ($user->status == '1') {
            echo "<td><span style='color:green'> Active</span></td>";
        } else {
            echo "<td><span style='color:red'> Inctive</span></td>";
        } ?>
    </tr>

    <tr>
        <td></td>
        <td>
            <a href='edit_profile.php?user_id=<?php echo $user->id; ?>' class='btn btn-info left-margin'>
                <span class='glyphicon glyphicon-edit'></span> Edit</a>
        </td>
    </tr>

</table>

<?php

//layout footer
include_once 'layouts/layout_footer.php';

?>