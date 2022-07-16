<?php  session_start(); 
    include("Services/PhotoService.php");
    if (!isset($_COOKIE["UserId"])) {
        header("Refresh:0;url=index.php");
    }
    if (isset($_POST["UploadPhotoModal"])) {
        unset($_SESSION["AlbumId"]);
    }
    if (isset($_POST["CreateAlbumModal"])) {
        unset($_SESSION["AlbumId"]);
    }
?>
<?php
    if (isset($_POST["btnUpdateAlbum"])) {
        $album = UpdateAlbum($_SESSION["AlbumId"], $_POST["title"], $_POST["description"], $_COOKIE["UserId"]);
        if ($album == null) {
            echo '
                <script>alert("Album Update failed.")</script>
            ';
        } else {
            unset($_SESSION["AlbumId"]);
            header("Refresh:0;url=Album.php");
        }
    }
?>
<?php
    if (isset($_POST["btnCreateAlbum"])) {
        unset($_SESSION["AlbumId"]);
        $album = CreateAlbum($_POST["title"], $_POST["description"], $_COOKIE["UserId"]);
        if ($album == null) {
            echo '
                <script>alert("Album creation failed.")</script>
            ';
        } else {
            header("Refresh:0;url=Album.php");
        }
    }
?>
<?php 
    if (isset($_POST["btnUploadPhoto"])) {
        $_SESSION["AlbumId"] = $_POST["SelectedAlbum"];
        $photo = UploadPhotos($_FILES["images"], $_COOKIE["UserId"], $_POST["SelectedAlbum"]);
        header("Refresh:0;url=Album.php");
    }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Add Edit</title>
        <!-- CSS only -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
        <style>
            .image-thumbail {
                height: 200px;
                object-fit: cover;
            }
            .list-group-item a {
                text-decoration: none;
                color: black;
            }
        </style>
    </head>
    <body>
        <?php include("Shared/Navbar.php") ?>
        <div class="container m-5">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <a href="Album.php" class="btn btn-dark">Go Back</a>
                    <div class="card my-5">
                        <!-- Update Album Modal -->
                        <?php
                            if (isset($_POST["UpdateAlbumModal"]) || isset($_SESSION["AlbumId"])) {
                                if (isset($_POST["UpdateAlbumModal"])) {
                                    $_SESSION["AlbumId"] = $_POST["UpdateAlbumModal"];
                                } 
                            $album = GetAlbumById($_SESSION["AlbumId"]);
                                if ($album == null) {
                                    echo '
                                        <script>alert("Album error")</script>
                                    ';
                                } else {
                                    echo '
                                        <form action="AddEdit.php" method="post" enctype="multipart/form-data">
                                            <div class="card-header">
                                                <h4 class="form-group m-3">Update Album Details</h4>
                                            </div>
                                            <div class="card-body">
                                            <div class="form-group m-3">
                                                <label class="form-label">Album Title</label>
                                                <input type="text" class="form-control" id="title" name="title" aria-describedby="emailHelp" value="'.$album["Title"].'">
                                                </div>
                                                <div class="form-group m-3">
                                                    <label class="form-label">Description</label>
                                                    <input type="text" class="form-control" id="description" name="description" value="'.$album["Description"].'">
                                                </div>
                                                <button type="submit" class="btn btn-dark m-3" id="btnUpdateAlbum" name="btnUpdateAlbum">Update</button>
                                            </div>
                                        </form>
                                    ';
                                }
                            }
                        ?>
                        <?php 
                            if (isset($_POST["CreateAlbumModal"])) {
                                echo '
                                    <form action="AddEdit.php" method="post" enctype="multipart/form-data">
                                        <div class="card-header">
                                            <h4 class="form-group m-3">Create Album</h4>
                                        </div>
                                        <div class="card-body">
                                            <div class="form-group m-3">
                                                <label class="form-label">Album Title</label>
                                                <input type="text" class="form-control" id="title" name="title" aria-describedby="emailHelp">
                                            </div>
                                            <div class="form-group m-3">
                                                <label class="form-label">Description</label>
                                                <input type="text" class="form-control" id="description" name="description">
                                            </div>
                                            <button type="submit" class="btn btn-dark m-3" id="btnCreateAlbum" name="btnCreateAlbum">Create</button>
                                        </div>
                                    </form>
                                ';
                            }
                        ?>
                        <?php 
                            if (isset($_POST["UploadPhotoModal"])) {
                                $albums = GetAlbumsByUserId($_COOKIE["UserId"]);
                                echo '
                                   <form action="AddEdit.php" method="post" enctype="multipart/form-data">
                                        <div class="card-header">
                                            <h4 class="form-group m-3">Upload Photo</h4>
                                        </div>
                                        <div class="card-body">
                                            <div class="form-group m-3">
                                                <label class="form-label">Select Album</label>
                                                <select name="SelectedAlbum" class="form-control">
                                                    <option value="">Select a album....</option>               
                                ';
                                foreach ($albums as $key => $values) {
                                    echo '
                                        <option value="'.$values["Id"].'">'.$values["Title"].'</option>
                                    ';
                                }
                                echo '
                                                </select>
                                            </div>
                                            <div class="form-group m-3">
                                                <label class="form-label">Upload Image</label>
                                                <input required name="images" type="file" multiple class="form-control-file">
                                            </div>
                                            <button type="submit" class="btn btn-dark m-3" id="btnUploadPhoto" name="btnUploadPhoto">Upload</button>
                                        </div>
                                    </form>
                                ';               
                            }
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <?php include("Shared/Footer.php") ?>
    </body>
</html>