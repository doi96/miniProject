<?php

//include database and object 
include_once "config/Database.php";
$database = new Database();
$db = $database->getConnection();

include_once "Controller/Category.php";
$category = new Category($db);

//include layout_header.php 
$page_title = "View Category";
include_once "layouts/layout_header.php";

// Query readAllCategory
$stmt = $category->read();

// create category and back to index button
echo "<div class='right-button-margin'>";
echo "<a href='create_category.php' class='btn btn-success pull-right'>";
echo "<span class='glyphicon glyphicon-plus'></span> Add Category";
echo "</a>";
echo "<a href='index.php' class='btn btn-primary pull-right' style='margin-right:2px;'>";
echo " Home";
echo "</a>";
echo "</div>";

//Display all category
echo "<table class='table table-hover table-responsive table-bordered'>";
    echo "<tr>";
        echo "<th>ID</th>";
        echo "<th>Name</th>";
        echo "<th>Status</th>";
        echo "<th>Actions</th>";
    echo "</tr>";
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
    echo "<tr>";
        echo "<td>{$id}</td>";
        echo "<td>{$name}</td>";
        if ($status=='Active') {
            echo "<td><a href='change_statusCate.php?id={$id}'><span style='color:green'>{$status}</span></a></td>";
        }else{
            echo "<td><a href='change_statusCate.php?id={$id}'><span style='color:red'>{$status}</span></a></td>";
        }
        
        echo "<td>";
            // edit category button
            echo "<a href='update_category.php?id={$id}' class='btn btn-info left-margin'>";
            echo "<span class='glyphicon glyphicon-edit'></span> Edit";
            echo "</a>";

        echo "</td>";
    echo "</tr>";
    }
echo "</table>";
//include footer layout
include_once "layouts/layout_footer.php";
?>