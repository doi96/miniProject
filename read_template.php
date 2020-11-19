<?php
// search form
echo "<form role='search' action='search.php'>";
    echo "<div class='input-group col-md-3 pull-left margin-right-1em'>";
        $search_value=isset($search_term) ? "value='{$search_term}'" : "";
        echo "<input type='text' class='form-control' placeholder='Type product name or description...' name='s' id='srch-term' required {$search_value} />";
        echo "<div class='input-group-btn'>";
            echo "<button class='btn btn-primary' type='submit'><i class='glyphicon glyphicon-search'></i></button>";
        echo "</div>";
    echo "</div>";
echo "</form>";
  
// create product button
echo "<div class='right-button-margin'>";
    echo "<a href='create_product.php' class='btn btn-primary pull-right'>";
        echo "<span class='glyphicon glyphicon-plus'></span> Create Product";
    echo "</a>";

    echo "<a href='view_category.php' class='btn btn-success pull-right' style='margin-right:2px;'>";
        echo " Category";
    echo "</a>";
echo "</div>";

echo " <div class='right-button-margin'>";
echo        "<form action='' method='post'>";
echo           "<button type='submit' id='btnExport' name='export' ";
echo                "value='Export to Excel' class='btn btn-info'>Export";
echo          " to Excel</button>";
echo        "</form>";
echo    "</div>";


// display the products if there are any
if($total_rows>0){
  
    echo "<table class='table table-hover table-responsive table-bordered'>";
        echo "<tr>";
            echo "<th>ID</th>";
            echo "<th>Product</th>";
            echo "<th>Price</th>";
            echo "<th>Description</th>";
            echo "<th>Category</th>";
            echo "<th>Status</th>";
            echo "<th>Actions</th>";
        echo "</tr>";
  
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
  
            extract($row);
  
            echo "<tr>";
                echo "<td>{$id}</td>";
                echo "<td>{$name}</td>";
                echo "<td>".number_format($price)." vnđ</td>";
                echo "<td>{$description}</td>";
                echo "<td>";
                    $category->id = $category_id;
                    $category->readName();
                    echo $category->name;
                echo "</td>";
                if($status=='Active'){
                echo "<td><a href='change_status.php?id={$id}'><span style='color: green'>{$status}</span></a></td>";
                }else{
                echo "<td><a href='change_status.php?id={$id}'><span style='color: red'>{$status}</span></a></td>";
                }


                echo "<td>";
  
                    // read product button
                    echo "<a href='read_one.php?id={$id}' class='btn btn-primary left-margin'>";
                        echo "<span class='glyphicon glyphicon-list'></span> Read";
                    echo "</a>";
  
                    // edit product button
                    echo "<a href='update_product.php?id={$id}' class='btn btn-info left-margin'>";
                        echo "<span class='glyphicon glyphicon-edit'></span> Edit";
                    echo "</a>";
  
                    // delete product button
                    echo "<a delete-id='{$id}' class='btn btn-danger delete-object'>";
                        echo "<span class='glyphicon glyphicon-remove'></span> Delete";
                    echo "</a>";
  
                echo "</td>";
  
            echo "</tr>";
        if (isset($_POST["export"])) {
            $product->exportProductDatabase($AllResult);
        }

        }
  
    echo "</table>";
  
    // paging buttons
    include_once 'Controller/paging.php';
    
}
  
// tell the user there are no products
else{
    echo "<div class='alert alert-danger'>No products found.</div>";
}
?>