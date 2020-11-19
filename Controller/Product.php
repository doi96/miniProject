<?php

class Product{
  
    // database connection and table name
    private $conn;
    private $table_name = "products";
  
    // object properties
    public $id;
    public $name;
    public $price;
    public $description;
    public $category_id;
    public $timestamp;
    public $status;
    public $image;
    public $video;
  
    public function __construct($db){
        $this->conn = $db;
    }
  
    // create product
    function create(){
  
        //write query
        $query = "INSERT INTO
                    " . $this->table_name . "
                SET
                    name=:name, price=:price, description=:description, category_id=:category_id, created=:created, status=:status, image=:image, video=:video";
  
        $stmt = $this->conn->prepare($query);
  
        // posted values
        $this->name=htmlspecialchars(strip_tags($this->name));
        $this->price=htmlspecialchars(strip_tags($this->price));
        $this->description=htmlspecialchars(strip_tags($this->description));
        $this->category_id=htmlspecialchars(strip_tags($this->category_id));
        $this->image = htmlspecialchars(strip_tags($this->image));
        $this->video = htmlspecialchars(strip_tags($this->video));
        $this->status= htmlspecialchars(strip_tags($this->status));
        
  
        // to get time-stamp for 'created' field
        $this->timestamp = date('Y-m-d H:i:s');
  
        // bind values 
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":price", $this->price);
        $stmt->bindParam(":description", $this->description);
        $stmt->bindParam(":category_id", $this->category_id);
        $stmt->bindParam(":created", $this->timestamp);
        $stmt->bindParam(":status", $this->status);
        $stmt->bindParam(":image", $this->image);
        $stmt->bindParam(":video", $this->video);

        if($stmt->execute()){
            return true;
        }else{
            return false;
        }
  
    }

    // will upload image file to server
    function uploadPhoto()
    {

        $result_message = "";

        // now, if image is not empty, try to upload the image
        if ($this->image) {

            // sha1_file() function is used to make a unique file name
            $target_directory = "uploads/images/";
            $target_file = $target_directory . $this->image;
            $file_type = pathinfo($target_file, PATHINFO_EXTENSION);

            // error message is empty
            $file_upload_error_messages = "";
            // make sure that file is a real image
            $check = getimagesize($_FILES["image"]["tmp_name"]);
            if ($check !== false) {
                // submitted file is an image
            } else {
                $file_upload_error_messages .= "<div>Submitted file is not an image.</div>";
            }

            // make sure certain file types are allowed
            $allowed_file_types = array("jpg", "jpeg", "png", "gif");
            if (!in_array($file_type, $allowed_file_types)) {
                $file_upload_error_messages .= "<div>Only JPG, JPEG, PNG, GIF files are allowed.</div>";
            }

            // make sure file does not exist
            if (file_exists($target_file)) {
                $file_upload_error_messages .= "<div>Image already exists. Try to change file name.</div>";
            }

            // make sure submitted file is not too large, can't be larger than 5 MB
            if ($_FILES['image']['size'] > (1024000 * 5)) {
                $file_upload_error_messages .= "<div>Image must be less than 5 MB in size.</div>";
            }

            // make sure the 'uploads' folder exists
            // if not, create it
            if (!is_dir($target_directory)) {
                mkdir($target_directory, 0777, true);
            }
            // if $file_upload_error_messages is still empty
            if (empty($file_upload_error_messages)) {
                // it means there are no errors, so try to upload the file
                if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                    // it means photo was uploaded
                } else {
                    $result_message .= "<div class='alert alert-danger'>";
                    $result_message .= "<div>Unable to upload photo.</div>";
                    $result_message .= "<div>Update the record to upload photo.</div>";
                    $result_message .= "</div>";
                }
            }

            // if $file_upload_error_messages is NOT empty
            else {
                // it means there are some errors, so show them to user
                $result_message .= "<div class='alert alert-danger'>";
                $result_message .= "{$file_upload_error_messages}";
                $result_message .= "<div>Update the record to upload photo.</div>";
                $result_message .= "</div>";
            }
        }

        return $result_message;
    }

    // Upload video file to serve
    function uploadVideo(){
        $result_message = "";

        // now, if video is not empty, try to upload the video
        if ($this->video) {

            // sha1_file() function is used to make a unique file name
            $target_directory = "uploads/videos/";
            $target_file = $target_directory . $this->video;
            $file_type = pathinfo($target_file, PATHINFO_EXTENSION);

            // error message is empty
            $file_upload_error_messages = "";

            // make sure certain file types are allowed
            $allowed_file_types = array("mp4", "avi");
            if (!in_array($file_type, $allowed_file_types)) {
                $file_upload_error_messages .= "<div>Only mp4, avi files are allowed.</div>";
            }

            // make sure file does not exist
            if (file_exists($target_file)) {
                $file_upload_error_messages .= "<div>Video already exists. Try to change file name.</div>";
            }

            // make sure submitted file is not too large, can't be larger than 5 MB
            if ($_FILES['video']['size'] > (1024000 * 5)) {
                $file_upload_error_messages .= "<div>Videos must be less than 5 MB in size.</div>";
            }

            // make sure the 'videos' folder exists
            // if not, create it
            if (!is_dir($target_directory)) {
                mkdir($target_directory, 0777, true);
            }
            // if $file_upload_error_messages is still empty
            if (empty($file_upload_error_messages)) {
                // it means there are no errors, so try to upload the file
                if (move_uploaded_file($_FILES["video"]["tmp_name"], $target_file)) {
                    // it means video was uploaded
                } else {
                    $result_message .= "<div class='alert alert-danger'>";
                    $result_message .= "<div>Unable to upload video.</div>";
                    $result_message .= "<div>Update the record to upload video.</div>";
                    $result_message .= "</div>";
                }
            }

            // if $file_upload_error_messages is NOT empty
            else {
                // it means there are some errors, so show them to user
                $result_message .= "<div class='alert alert-danger'>";
                $result_message .= "{$file_upload_error_messages}";
                $result_message .= "<div>Update the record to upload video.</div>";
                $result_message .= "</div>";
            }
        }

        return $result_message;
    }

    function readAll($from_record_num, $records_per_page)
    {

        $query = "SELECT
                id, name, description, price, category_id, status
            FROM
                " . $this->table_name . "
            ORDER BY
                id DESC
            LIMIT
                {$from_record_num}, {$records_per_page}";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt;
    }

    function readAllReult()
    {

        $query = "SELECT
                *
            FROM
                " . $this->table_name . " ";

        $AllResult = $this->conn->prepare($query);
        $AllResult->execute();

        return $AllResult;
    }

    // used for paging products
    public function countAll()
    {

        $query = "SELECT id FROM " . $this->table_name . "";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        $num = $stmt->rowCount();

        return $num;
    }

    function readOne()
    {

        $query = "SELECT
                name, price, description, category_id, status,image, video
            FROM
                " . $this->table_name . "
            WHERE
                id = ?
            LIMIT
                0,1";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->name = $row['name'];
        $this->price = $row['price'];
        $this->description = $row['description'];
        $this->category_id = $row['category_id'];
        $this->status = $row['status'];
        $this->image = $row['image'];
        $this->video = $row['video'];
    }

    function update()
    {

        $query = "UPDATE
                " . $this->table_name . "
            SET
                name = :name,
                price = :price,
                description = :description,
                category_id  = :category_id,
                status =:status
            WHERE
                id = :id";

        $stmt = $this->conn->prepare($query);

        // posted values
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->price = htmlspecialchars(strip_tags($this->price));
        $this->description = htmlspecialchars(strip_tags($this->description));
        $this->category_id = htmlspecialchars(strip_tags($this->category_id));
        $this->id = htmlspecialchars(strip_tags($this->id));

        if(!empty($_POST['status'])){
            $this->status = 'Active';
        }else{
            $this->status = 'Inactive';
        }

        // bind parameters
        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':price', $this->price);
        $stmt->bindParam(':description', $this->description);
        $stmt->bindParam(':category_id', $this->category_id);
        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':status', $this->status);

        // execute the query
        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    // delete the product
    function delete()
    {
        $img = "SELECT image,video FROM " . $this->table_name . " WHERE id = ?";
        $img = $this->conn->prepare($img);
        $img -> bindParam(1, $this->id);
        $img ->execute();
        $row = $img->fetch(PDO::FETCH_ASSOC);
        $images = $row['image'];
        $videos = $row['video'];
        // echo $images; die;

        unlink("uploads/images/" .$images);
        unlink("uploads/videos/" . $videos);


        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);

        if ($result = $stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    // read products by search term
    public function search($search_term, $from_record_num, $records_per_page)
    {

        // select query
        $query = "SELECT
                c.name as category_name, p.id, p.name, p.description, p.price, p.category_id, p.created, p.status
            FROM
                " . $this->table_name . " p
                LEFT JOIN
                    categories c
                        ON p.category_id = c.id
            WHERE
                p.name LIKE ? OR p.description LIKE ?
            ORDER BY
                p.name ASC
            LIMIT
                ?, ?";

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // bind variable values
        $search_term = "%{$search_term}%";
        $stmt->bindParam(1, $search_term);
        $stmt->bindParam(2, $search_term);
        $stmt->bindParam(3, $from_record_num, PDO::PARAM_INT);
        $stmt->bindParam(4, $records_per_page, PDO::PARAM_INT);

        // execute query
        $stmt->execute();

        // return values from database
        return $stmt;
    }

    public function countAll_BySearch($search_term)
    {

        // select query
        $query = "SELECT
                COUNT(*) as total_rows
            FROM
                " . $this->table_name . " p 
            WHERE
                p.name LIKE ? OR p.description LIKE ?";

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // bind variable values
        $search_term = "%{$search_term}%"; 
        $stmt->bindParam(1, $search_term);
        $stmt->bindParam(2, $search_term);

        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        return $row['total_rows'];
    }

    public function change_status(){
        //get Status
        $sttquery = "SELECT status FROM ".$this->table_name. " WHERE id = ?";
        $sttquery = $this->conn->prepare($sttquery);
        $sttquery->bindParam(1, $this->id);
        $sttquery->execute();
        $row = $sttquery->fetch(PDO::FETCH_ASSOC);
        
        if($row['status']=='Active'){
            $status = "Inactive";
            // change status
            $query = "UPDATE products SET status=:status WHERE id =:id ";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":id", $this->id);
            $stmt->bindParam(":status", $status);
            $stmt->execute();
        }else{
            $status = "Active";
            // change status
            $query = "UPDATE products SET status=:status WHERE id =:id ";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":id", $this->id);
            $stmt->bindParam(":status", $status);
            $stmt->execute();
        }
        return true;
    }

    function exportProductDatabase($AllResult){
        //Retrieve the data from our table.
        // $rows = $AllResult->fetchAll(PDO::FETCH_ASSOC);

        $filename = "Webinfopen.xls"; // File Name
        // Download file
        header("Content-Disposition: attachment; filename=\"$filename\"");
        header("Content-Type: application/vnd.ms-Excel");
        // $user_query = mysql_query('select name,work from info');
        // Write data to file
        $flag = false;
        while ($rows = $AllResult->fetchAll(PDO::FETCH_ASSOC)) {
            if (!$flag) {
                // display field/column names as first row
                echo implode("\t", array_keys($rows)) . "\r\n";
                $flag = true;
            }
            echo implode("\t", array_values($rows)) . "\r\n";
        }
    }
}
?>