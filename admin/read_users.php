<?php 
    //include databasea and class object
    include_once '../config/core.php';
    include_once '../config/Database.php';
    include_once '../Controller/User.php';
    $database = new Database();
    $db = $database->getConnection();

    $page_title = 'Read Users';

    $user = new User($db);

    //include header
    include 'layout_header.php';

    echo "<div class='col-md-12'>";

    // read all users from the database
    $stmt = $user->readAll($from_record_num, $records_per_page);

    // count retrieved users
    $num = $stmt->rowCount();

    // to identify page for paging
    $page_url = "read_users.php?";

    // include products table HTML template
    include_once "read_users_template.php";

    echo "</div>";

    // include footer layout
    include 'layout_footer.php';
?>