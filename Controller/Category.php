<?php
class Category{
  
    // database connection and table name
    private $conn;
    private $table_name = "categories";
  
    // object properties
    public $id;
    public $name;
    public $status;
    public $timestamps;
  
    public function __construct($db){
        $this->conn = $db;
    }
  
    // used by select drop-down list
    function read(){
        //select all data
        $query = "SELECT
                    id, name, status
                FROM
                    " . $this->table_name . "
                ORDER BY
                    id DESC";  
  
        $stmt = $this->conn->prepare( $query );
        $stmt->execute();
  
        return $stmt;
    }

    // used to read category name by its ID
    function readName(){
        $query = "SELECT id, name, status FROM " . $this->table_name . " WHERE id = ? limit 0,1";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->name = $row['name'];
        $this->status = $row['status'];
        $this->id = $row['id'];
    }

    function create(){
        $query = "INSERT INTO " . $this->table_name . " SET name=:name,status=:status, created=:created";
        $stmt = $this->conn->prepare($query);
        $this->name = htmlspecialchars(strip_tags($this->name));
        if (!empty($_POST['status'])) {
            $this->status = 'Active';
        } else {
            $this->status = 'Inactive';
        }
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":status", $this->status);
        $stmt->bindParam(":created", $this->timestamps);
        // to get time-stamp for 'created' field
        $this->timestamps = date('Y-m-d H:i:s');
        if ($stmt->execute()) {
            return true;
        }

    }

    function edit(){
        $query = "UPDATE " . $this->table_name . " SET name=:name, status=:status WHERE id=:id";
        $stmt = $this->conn->prepare($query);

        if (!empty($_POST['status'])) {
            $this->status = 'Active';
        } else {
            $this->status = 'Inactive';
        }

        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':status', $this->status);

        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->id = htmlspecialchars(strip_tags($this->id));
        
        if ($stmt->execute()) {
            return true;
        }
    }

    function change_status(){
        // echo $this->id;die;
        //Get status off category
        $sttquery = "SELECT status FROM " . $this->table_name . " WHERE id = ? LIMIT 0,1";
        $stt = $this->conn->prepare($sttquery);
        $stt->bindParam(1,$this->id);
        $this->id = htmlspecialchars(strip_tags($this->id));
        $stt->execute();
        $row = $stt->fetch(PDO::FETCH_ASSOC);

        //Change status
        if ($row['status']=='Active') {
            // echo 'Inactive';die;
            $status = 'Inactive';
            $query = "UPDATE " .$this->table_name. " SET status=:status WHERE id=:id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':status',$status);
            $stmt->bindParam(':id', $this->id);
            $stmt->execute();
        }else{
            $status = 'Active';
            $query = "UPDATE " . $this->table_name . " SET status=:status WHERE id=:id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':status', $status);
            $stmt->bindParam(':id', $this->id);
            $stmt->execute();
        }
    }

  
}
?>