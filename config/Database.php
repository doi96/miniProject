<?php 
    class Database{
        private $host = "localhost";
        private $username = "root";
        private $password ="";
        private $db_name = "OOP_miniPHP_Login";
        public $conn;
        
        public function getConnection(){
            $this->conn = null;
            try {
                $this->conn = new PDO("mysql:host=".$this->host.";dbname=".$this->db_name,$this->username,$this->password);
            } catch (PDOException $e) {
                echo "ERROR:" .$e->getMessage();
            }
            return $this->conn;
        } 
    }
?>