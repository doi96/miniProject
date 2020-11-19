<?php 
    class User{
        //Connect database
        private $conn;
        private $table_name='users';

        //Object properties
        public $id;
        public $firstname;
        public $lastname;
        public $email;
        public $contact_number;
        public $address;
        public $password;
        public $access_level;
        public $access_code;
        public $status;
        public $created;
        public $modified; 

        //Contrustor
        public function __construct($db)
        {
            $this->conn=$db;
        }

    // check if given email exist in the database
    function emailExists()
    {

        // query to check if email exists
        $query = "SELECT id, firstname, lastname, access_level, password, status
            FROM " . $this->table_name . "
            WHERE email = ?
            LIMIT 0,1";

        // prepare the query
        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->email = htmlspecialchars(strip_tags($this->email));

        // bind given email value
        $stmt->bindParam(1, $this->email);

        // execute the query
        $stmt->execute();

        // get number of rows
        $num = $stmt->rowCount();

        // if email exists, assign values to object properties for easy access and use for php sessions
        if ($num > 0) {

            // get record details / values
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            // assign values to object properties
            $this->id = $row['id'];
            $this->firstname = $row['firstname'];
            $this->lastname = $row['lastname'];
            $this->access_level = $row['access_level'];
            $this->password = $row['password'];
            $this->status = $row['status'];

            // return true because email exists in the database
            return true;
        }

        // return false if email does not exist in the database
        return false;
    }

    // create new user record
    function create()
    {

        // to get time stamp for 'created' field
        $this->created = date('Y-m-d H:i:s');

        // insert query
        $query = "INSERT INTO
                " . $this->table_name . "
            SET
                firstname = :firstname,
                lastname = :lastname,
                email = :email,
                contact_number = :contact_number,
                address = :address,
                password = :password,
                access_level = :access_level,
                access_code = :access_code,
                status = :status,
                created = :created";

        // prepare the query
        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->firstname = htmlspecialchars(strip_tags($this->firstname));
        $this->lastname = htmlspecialchars(strip_tags($this->lastname));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->contact_number = htmlspecialchars(strip_tags($this->contact_number));
        $this->address = htmlspecialchars(strip_tags($this->address));
        $this->password = htmlspecialchars(strip_tags($this->password));
        $this->access_level = htmlspecialchars(strip_tags($this->access_level));
        $this->access_code = htmlspecialchars(strip_tags($this->access_code));
        $this->status = htmlspecialchars(strip_tags($this->status));

        // bind the values
        $stmt->bindParam(':firstname', $this->firstname);
        $stmt->bindParam(':lastname', $this->lastname);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':contact_number', $this->contact_number);
        $stmt->bindParam(':address', $this->address);

        // hash the password before saving to database
        $password_hash = password_hash($this->password, PASSWORD_BCRYPT);
        $stmt->bindParam(':password', $password_hash);

        $stmt->bindParam(':access_level', $this->access_level);
        $stmt->bindParam(':access_code', $this->access_code);
        $stmt->bindParam(':status', $this->status);
        $stmt->bindParam(':created', $this->created);
        // echo $this->access_code;die;
        // execute the query, also check if query was successful
        if ($stmt->execute()) {
            return true;
        } else {
            $this->showError($stmt);
            return false;
        }
    }

    public function showError($stmt)
    {
        echo "<pre>";
        print_r($stmt->errorInfo());
        echo "</pre>";
    }

    function readAll($from_record_num, $records_per_page){
        // read all user records
        // query to read all user records, with limit clause for pagination
        $query = "SELECT
            id,
            firstname,
            lastname,
            email,
            contact_number,
            access_level,
            created
        FROM " . $this->table_name . "
        ORDER BY id DESC
        LIMIT ?, ?";

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // bind limit clause variables
        $stmt->bindParam(1, $from_record_num, PDO::PARAM_INT);
        $stmt->bindParam(2, $records_per_page, PDO::PARAM_INT);

        // execute query
        $stmt->execute();

        // return values
        return $stmt;
    }

    // used for paging users
    public function countAll()
    {

        // query to select all user records
        $query = "SELECT id FROM " . $this->table_name . "";

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // execute query
        $stmt->execute();

        // get number of rows
        $num = $stmt->rowCount();

        // return row count
        return $num;
    }

    //check exist accont with access code
    function checkExistAccount()
    {
        $query = "SELECT id FROM " . $this->table_name . " WHERE access_code = ? ";
        $stmt = $this->conn->prepare($query);
        $this->access_code = htmlspecialchars(strip_tags($this->access_code));
        $stmt->bindParam(1,$this->access_code);
        $stmt->execute();
        $row = $stmt->rowCount();
        // echo $row;die;
        if ($row > 0) {
            //query update status
            $sttquery = "UPDATE " . $this->table_name . " SET status=:status WHERE access_code=:access_code ";
            $changeStatus = $this->conn->prepare($sttquery);
            $this->status = 1;
            $this->access_code = htmlspecialchars(strip_tags($this->access_code));
            $changeStatus->bindParam(":status", $this->status);
            $changeStatus->bindParam(":access_code", $this->access_code);
            if($changeStatus->execute()){
                return true;
            }
        }else{
            return false;

        }
    }

    function updateAccessCode(){
        // echo $this->email;die;
        $query = "UPDATE " .$this->table_name. " SET access_code=:access_code WHERE email=:email";
        $stmt = $this->conn->prepare($query);
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->access_code = htmlspecialchars(strip_tags($this->access_code));
        $stmt->bindParam(":email",$this->email);
        $stmt->bindParam(":access_code", $this->access_code);
        if($stmt->execute()){
            return true;
        }else{
            return false;
        }
    }

    function accessCodeExists(){
        // echo $this->access_code;die; 
        $query = "SELECT id FROM " .$this->table_name. " WHERE access_code=? ";
        $stmt = $this->conn->prepare($query);
        $this->access_code = htmlspecialchars(strip_tags($this->access_code));
        $stmt->bindParam(1,$this->access_code);
        $stmt->execute();
        $row = $stmt->rowCount();
        if ($row > 0) {
            return true;
        }else{
            return false;
        }
    } 
    
    function updatePassword(){
        // echo $this->access_code; echo $this->password;die;

        $query = "UPDATE " .$this->table_name. " SET password=:password WHERE access_code=:access_code" ;
        $stmt = $this->conn->prepare($query);
        $this->password = htmlspecialchars(strip_tags($this->password));
        $hash_password = password_hash($this->password,PASSWORD_BCRYPT);
        $this->access_code = htmlspecialchars(strip_tags($this->access_code));
        $stmt->bindParam(":password",$hash_password);
        $stmt->bindParam(":access_code",$this->access_code);
        if($stmt->execute()){
            return true;
        }else{
            return false;
        }
    }

    //Get profile user
    function readProfile(){
        $query = " SELECT * FROM " .$this->table_name. " WHERE id = ? ";
        $stmt = $this->conn->prepare($query);
        $this->id = htmlspecialchars(strip_tags($this->id));
        $stmt->bindParam(1,$this->id);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->firstname = $row['firstname'];
        $this->lastname = $row['lastname'];
        $this->address = $row['address'];
        $this->email = $row['email'];
        $this->contact_number = $row['contact_number'];
        $this->status = $row['status'];

    }

    //edit profile 
    function editProfile(){
        $query = " UPDATE " .$this->table_name. " SET firstname=:firstname, lastname=:lastname,address=:address,contact_number=:contact_number,email=:email WHERE id=:id" ;
        $stmt = $this->conn->prepare($query);
        $this->firstname = htmlspecialchars(strip_tags($this->firstname));
        $this->address = htmlspecialchars(strip_tags($this->address));
        $this->lastname = htmlspecialchars(strip_tags($this->lastname));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->contact_number = htmlspecialchars(strip_tags($this->contact_number));
        $this->id = htmlspecialchars(strip_tags($this->id));
        $stmt->bindParam(':firstname',$this->firstname);
        $stmt->bindParam(':lastname', $this->lastname);
        $stmt->bindParam(':address', $this->address);
        $stmt->bindParam(':contact_number', $this->contact_number);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':id', $this->id);
        if($stmt->execute()){
            return true;
        }else{
            return false;
        }
    }
    }

    
?>