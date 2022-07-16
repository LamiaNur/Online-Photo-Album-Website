<?php 
    $ROOT_DIR = 'C:/xampp/htdocs/PhotoAlbum';
    include("DatabaseService.php");
    
    // If user exist then return null else return the created user
    function CreateUser($firstName,$lastName,$email,$password) {
        $user = GetUserByEmail($email);
        if ($user != null) return null;
        $createdAt = date('Y-m-d H:i:s', time());
        $query = "insert into usermodel(FirstName,LastName,Email,Password,CreatedAt) values ('$firstName','$lastName','$email','$password','$createdAt')";
        $queryResult = ExecuteQuery($query);
        if ($queryResult) return GetUserByEmail($email);
        return null;
    }
    function UpdateUser($id, $firstName, $lastName, $password) {
        $user = GetUserById($id);
        if ($user == null) return null;
        $query = "update usermodel set FirstName='$firstName',LastName='$lastName',Password='$password' where Id='$id'";
        $queryResult = ExecuteQuery($query);
        if ($queryResult) return GetUserById($id); 
        return null;
    }
    function DeleteUserById($id) {
        $user = GetUserById($id);
        if ($user == null) return null;
        $query = "delete from usermodel where Id='$id'";
        $queryResult = ExecuteQuery($query);
        if ($queryResult) return $user;
        return null;
    }
    // if email doesn't exist then return null
    function GetUserByEmail($email) {
        $query = "select * from usermodel where Email='$email'";
        $queryResult = ExecuteQuery($query);
        if (mysqli_num_rows($queryResult) > 0) {
            $user = $queryResult->fetch_assoc();
            return $user;
        }
        return null;
    }
    function GetUserById($id) {
        $query = "select * from usermodel where Id='$id'";
        $queryResult = ExecuteQuery($query);
        if (mysqli_num_rows($queryResult) > 0) {
            $user = $queryResult->fetch_assoc();
            return $user;
        }
        return null;
    }
    function GetAllUsers() {
        $query = "select * from usermodel";
        $queryResult = ExecuteQuery($query);
        if (mysqli_num_rows($queryResult) > 0) {
            $arr = array();
            while ($row = $queryResult->fetch_assoc()) {
                $arr[] = $row;
            }
            return $arr;
        }
        return null;
    }
    // $ans = DeleteUserById(9);
    //$ans = UpdateUser("aasap","bbbbb","abd@gmail.com","1234");
    //$ans = GetUserByEmail("ab@gmail.com");
    // $ans = GetAllUsers();
    // print_r($ans != null? $ans : "null");
?>