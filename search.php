<?php 
    include_once "config/core.php";
    include_once "Controller/Category.php";
    include_once "Controller/Product.php";
    include_once "config/Database.php";
    $database = new Database();
    $db = $database->getConnection();

    $product = new Product($db);
    $category = new Category($db);

    //get search term
    $search_term = isset($_GET['s']) ? $_GET['s'] : '';

    $page_title = "Result for \"{$search_term}\"";
    include_once "layouts/layout_header.php";

    //query product
    $stmt = $product->search($search_term, $from_record_num, $records_per_page);

    // specify the page where paging is used
    $page_url = "search.php?s={$search_term}&";

    //Count rows - used for pagination
    $total_rows = $product->countAll_BySearch($search_term);
    
    //include read_templte and footer
    include_once "read_template.php";
    include_once "layouts/layout_footer.php";
?>