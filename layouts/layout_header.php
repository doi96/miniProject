<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title><?php echo $page_title; ?></title>

    <!-- Latest compiled and minified Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />

    <!-- our custom CSS -->
    <link rel="stylesheet" href="<?php echo $home_url; ?>/libs/css/custom.css" />
    <!-- admin custom css -->
    <link rel="stylesheet" href="<?php echo $home_url; ?>/libs/css/customer.css" />

</head>

<body>
    <!-- include navigation file -->
    <?php include_once "layouts/navigation.php" ?>
    <!-- container -->
    <div class="container">

        <?php
        // if given page title is 'Login', do not display the title
        if ($page_title != "Login") {
        ?>
            <div class='col-md-12'>
                <div class="page-header">
                    <h1><?php echo isset($page_title) ? $page_title : "Mini Project!"; ?></h1>
                </div>
            </div>
        <?php
        }
        ?>