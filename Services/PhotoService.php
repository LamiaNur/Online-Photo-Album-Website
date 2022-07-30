<?php 
    include("AlbumService.php");
    function UploadPhotoDetailsToDatabase($title, $path, $uploadedBy, $albumId) {
        $photo = GetPhotoByPath($path);
        if ($photo != null) return null;
        $user = GetUserById($uploadedBy);
        if ($user == null) return null;
        $album = GetAlbumById($albumId);
        if ($album == null) return null;
        $createdAt = date('Y-m-d H:i:s', time());
        $query = "insert into photomodel(Title,Path,UploadedBy,AlbumId,CreatedAt) values ('$title', '$path', '$uploadedBy','$albumId','$createdAt')";
        $queryResult = ExecuteQuery($query);
        if ($queryResult) return GetPhotoByPath($path);
        return null;
    }
    function UpdatePhoto($id, $title, $description, $albumId) {
        $photo = GetPhotoById($id);
        if ($photo == null) return null;
        $album = GetAlbumById($albumId);
        if ($albumId == null) return null;
        $query = "update photomodel set Title='$title',Description='$description',AlbumId='$albumId' where Id='$id'";
        $queryResult = ExecuteQuery($query);
        if ($queryResult) return GetPhotoById($id);
        return null; 
    }
    function DeletePhotoById($id) {
        $photo = GetPhotoById($id);
        if ($photo == null) return null;
        // $db = new Database();
        // $connection = $db->Connect();
        $query = "delete from photomodel where Id='$id'";
        // $queryResult = mysqli_query($connection, $query);
        $queryResult = ExecuteQuery($query);
        DeletePhotoFromFileByPath($photo["Path"]);
        if ($queryResult) return $photo;
        return null;
    }
    function DeletePhotosByAlbumId($albumId) {
        $album = GetAlbumById($albumId);
        if ($album == null) return null;
        $photos = GetPhotosByAlbumId($albumId);
        if ($photos == null) return null;
        $query = "delete from photomodel where AlbumId='$albumId'";
        $queryResult = ExecuteQuery($query);
        foreach ($photos as $key => $value) {
            DeletePhotoFromFileByPath($value["Path"]);
        }
        if ($queryResult) return $photos;
        return null;
    }
    function GetPhotoById($id) {
        $query = "select * from photomodel where Id='$id'";
        $queryResult = ExecuteQuery($query);
        if (mysqli_num_rows($queryResult) > 0) {
            $photo = $queryResult->fetch_assoc();
            return $photo;
        }
        return null;
    }
    function GetPhotoByPath($path) {
        $query = "select * from photomodel where Path='$path'";
        $queryResult = ExecuteQuery($query);
        if (mysqli_num_rows($queryResult) > 0) {
            $photo = $queryResult->fetch_assoc();
            return $photo;
        }
        return null;
    }
    function GetPhotosByUserId($userId) {
        $query = "select * from photomodel where UploadedBy='$userId'";
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
    function GetPhotosByAlbumId($albumId) {
        $query = "select * from photomodel where AlbumId='$albumId'";
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
    function DeletePhotoFromFileByPath($path) {
        unlink($path);
    }
    function UploadPhotos($files, $uploadedBy, $albumId) {
        $fileName = $files['name'];
        $fileTmpName = $files['tmp_name'];
        $fileSize = $files['size'];
        $fileError = $files['error'];
        $fileType = $files['type'];
        $fileExtension = explode('.', $fileName);
        $fileActualExtention = strtolower(end($fileExtension));
        $allowedExtentions = array('jpg', 'jpeg', 'png');
        $uploadSucces = 0;
        if (in_array($fileActualExtention, $allowedExtentions)) {
            if ($fileError == 0) {
                if ($fileSize < 5000000) {
                    $fileNewName = uniqid('', true).".".$fileActualExtention;
                    global $ROOT_DIR;
                    $fileDestination = 'uploads/'.$fileNewName;
                    move_uploaded_file($fileTmpName, $fileDestination);
                    $uploadSucces = 1;
                    $res = UploadPhotoDetailsToDatabase($fileName, $fileDestination, $uploadedBy, $albumId);
                    if ($res == null) return null;
                    return $res;
                } 
            } 
        } 
        if ($uploadSucces == 0) return null;
    }
    // $ans = GetPhotosByUserId(6);
    //$ans = GetPhotosByAlbumId(4);
    //$ans = GetPhotoByPath("C:xampphtdocsPhotoAlbum/uploads/62cd0545741097.81661418.jpg");
    //$ans = GetPhotoById(2);
    //$ans = UpdatePhoto(2, "hello", "this is edited", 3);
    //$ans = DeletePhotoById(2);
    //$ans = DeletePhotosByAlbumId(4);
    // print_r($ans != null? $ans : "null");
    /********************Statuts Functionalities******************/
    function CreateStatus($status, $numOfLikes, $photoId, $createdBy) {
        $createdAt = date('Y-m-d H:i:s', time());
        //$query = "insert into statusmodel(Status,NumberOfLikes,PhotoId,CreatedAt,UserId) values ('$status', '$numOfLikes','$photoId',$createdAt','$createdBy')";
        $query = "insert into statusmodel(Status, NumberOfLikes, PhotoId, CreatedAt,UserId) VALUES ('$status', '$numOfLikes', '$photoId', '$createdAt', '$createdBy')";
        $queryResult = ExecuteQuery($query);
        if ($queryResult) return 1;
        return null;
    }
    function GetStatusById($id) {
        $query = "select * from statusmodel where Id='$id'";
        $queryResult = ExecuteQuery($query);
        if (mysqli_num_rows($queryResult) > 0) {
            $status = $queryResult->fetch_assoc();
            return $status;
        }
        return null;
    }
    function GetAllStatusByUserId($userId) {
        $query = "select * from statusmodel where UserId='$userId'";
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
    function GetAllStatus() {
        $query = "select * from statusmodel order by Id desc";
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
    function UpdateStatus($id, $status, $numOfLikes) {
        $query = "update statusmodel set Status='$status',NumberOfLikes='$numOfLikes' where Id='$id'";
        $queryResult = ExecuteQuery($query);
        if ($queryResult) return GetStatusById($id);
        return null; 
    }
    // $ans = CreateStatus("hello", "0", "1", "1");
    //$ans = GetAllStatusByUserId(1);
    //print_r($ans != null? $ans : "null");
    /********************Comments Functionalities******************/
    function CreateComment($comment, $statusId, $whoCommented) {
        $createdAt = date('Y-m-d H:i:s', time());
        $query = "insert into commentmodel(Comment, StatusId, CreatedAt, WhoCommented) VALUES ('$comment', '$statusId', '$createdAt', '$whoCommented')";
        $queryResult = ExecuteQuery($query);
        if ($queryResult) return 1;
        return null;
    }
    function GetCommentById($id) {
        $query = "select * from commentmodel where Id='$id'";
        $queryResult = ExecuteQuery($query);
        if (mysqli_num_rows($queryResult) > 0) {
            $comment = $queryResult->fetch_assoc();
            return $comment;
        }
        return null;
    }
    function GetCommentsByStatusId($statusId) {
        $query = "select * from commentmodel where StatusId='$statusId' order by Id desc";
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

    /********************Like Functionalities******************/
    function CreateLike($statusId, $whoLiked) {
        $createdAt = date('Y-m-d H:i:s', time());
        $query = "insert into likemodel(StatusId, WhoLiked, CreatedAt) VALUES ( '$statusId' , '$whoLiked', '$createdAt')";
        $queryResult = ExecuteQuery($query);
        if ($queryResult) return 1;
        return null;
    }
    function GetLikeById($id) {
        $query = "select * from likemodel where Id='$id'";
        $queryResult = ExecuteQuery($query);
        if (mysqli_num_rows($queryResult) > 0) {
            $like = $queryResult->fetch_assoc();
            return $like;
        }
        return null;
    }
    function GetLikesByStatusId($statusId) {
        $query = "select * from likemodel where StatusId='$statusId' order by Id desc";
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
    function GetLikeByStatusIdAndUserId($statusId, $userId) {
        $query = "select * from likemodel where StatusId='$statusId' and WhoLiked ='$userId' order by Id desc";
        $queryResult = ExecuteQuery($query);
        if (mysqli_num_rows($queryResult) > 0) {
            $like = $queryResult->fetch_assoc();
            return $like;
        }
        return null;
    }

?>