<?php 
    class Database {
        private $Host = "localhost";
        private $UserName = "root";
        private $Password = "";
        private $DbName = "photo_album";
        public function Connect() {
            $connect = mysqli_connect($this->Host, $this->UserName, $this->Password, $this->DbName);
            return $connect;
        }
    }
    $DB_OBJECT = new Database();
    $CONNECTION = $DB_OBJECT->Connect();
    function ExecuteQuery($query) {
        global $CONNECTION;
        return mysqli_query($CONNECTION, $query);
    }
    function Debug($data) {
        echo "<pre>";
        print_r(($data == null)? "null" : $data);
        echo "</pre>";
    } 
?>