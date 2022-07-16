<?php  session_start(); 
    include("Services/PhotoService.php");
    if (!isset($_COOKIE["UserId"])) {
        header("Refresh:0;url=index.php");
    }
?>
<?php 
    if(isset($_POST["btnSelectedAlbum"])) {
        $_SESSION["AlbumId"] = $_POST["btnSelectedAlbum"];
    }
?>
<?php 
    if (isset($_POST["btnAllPhotos"])) {
        unset($_SESSION["AlbumId"]);
    }
?>
<?php 
    if (isset($_POST["btnDeleteAlbum"])) {
        $deletedPhotos = DeletePhotosByAlbumId($_SESSION["AlbumId"]);
        $album = DeleteAlbumById($_SESSION["AlbumId"]);
        unset($_SESSION["AlbumId"]);
    }
?>
<?php 
    if (isset($_POST["btnViewPhoto"])) {
        $_SESSION["PhotoId"] = $_POST["btnViewPhoto"];
        header("Refresh:0;url=Photo.php");
    }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Album</title>
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
            <div class="row">
                <!-- Side Nav -->
                <div class="col-md-4">
                    <div class="card">
                        <form class="card" method="post" action="AddEdit.php" enctype="multipart/form-data">
                            <button type="submit" class="btn btn-dark btn-block btn-sm m-1" name="CreateAlbumModal">Create Album</button>    
                        </form>
                        <div class="card-header">
                            <form method="post" action="Album.php">
                                <button type ="submit" class="btn btn-light" name="btnAllPhotos">All Photos</button>
                            </form>
                        </div>
                        <ul class="list-group list-group-flush">
                            <?php
                                $albums = GetAlbumsByUserId($_COOKIE["UserId"]);
                                if ($albums != null) {
                                    foreach ($albums as $key => $value) {
                                        echo '
                                            <li class="list-group-item">
                                                <div class="row">
                                                    <div class="col-md-9">
                                                        <form method="post" action="Album.php">
                                                            <button class="btn btn-ouline-dark" value='.$value["Id"].' name="btnSelectedAlbum">'.$value["Title"].'</button>
                                                        </form>
                                                    </div>
                                                    <div class="col-md-1">
                                                        <form  method="post" action="AddEdit.php">
                                                            <button class="btn" name="UpdateAlbumModal" value='.$value["Id"].'><i class="fa fa-edit"></i></button>
                                                        </form>
                                                    </div>
                                                </div> 
                                            </li>
                                        ';
                                    }
                                }    
                            ?>
                        </ul>
                    </div>
                </div>
                <!-- Photos -->
                <div class="col-md-8">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <?php 
                                    $AlbumDetails = null;
                                    if (isset($_SESSION["AlbumId"])) {
                                        $AlbumDetails = GetAlbumById($_SESSION["AlbumId"]);
                                    }
                                ?>
                                <div class="card-header">
                                    <div class="row">
                                        <div class="col-md-9">
                                            <?php 
                                                if ($AlbumDetails != null) {
                                                    echo '
                                                        <div class="row">
                                                            <div class="col-md-9">
                                                                <h3> '.$AlbumDetails["Title"].' </h3>
                                                            </div>
                                                            <div>Created at '.$AlbumDetails["CreatedAt"].'</div>
                                                        </div>
                                                    ';
                                                } else {
                                                    echo '
                                                       <h3> All Photos </h3> 
                                                    ';
                                                }
                                            ?>
                                        </div>
                                        <div class="col">
                                            <form method="post" action="AddEdit.php">
                                                <button type="submit" class="btn btn-dark btn-block" name="UploadPhotoModal">Upload Photos</button>
                                            </form>
                                            <?php 
                                                if ($AlbumDetails != null) { 
                                                    echo '
                                                        <button type="button" class="btn btn-danger btn-block my-2" name="ConfirmDeleteModal" data-bs-toggle="modal" data-bs-target="#ConfirmDeleteModal" value='.$AlbumDetails["Id"].'>Delete Album</button>
                                                    ';
                                                }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <h6> <u>Description</u> </h6>
                                    <?php 
                                        if ($AlbumDetails != null) {
                                            echo '
                                                <p>'.$AlbumDetails["Description"].'</p>
                                            ';
                                        } else {
                                            echo '
                                                <p>All photos in all the albums</p>
                                            ';
                                        }
                                    ?>
                                </div>
                            </div>
                        </div>
                        <!-- </div> -->
                        <?php
                            $photos = GetPhotosByUserId($_COOKIE["UserId"]);
                            if (isset($_SESSION["AlbumId"])) {
                                $photos = GetPhotosByAlbumId($_SESSION["AlbumId"]);
                            }
                            if ($photos == null) {
                                echo '
                                    <h4>No Photos</h4>
                                ';
                                
                            } else {
                                foreach ($photos as $key => $values) {
                                    echo '
                                        <div class="col-md-4">
                                            <div class="card my-2">
                                                <img class="image-thumbail" src="'.$values["Path"].'" alt="Card image cap">
                                                <div class="card-body">
                                                    <small>Title : '.$values["Title"].'</small>
                                                </div>
                                                <form method="post" action="Album.php">
                                                    <button type="submit" class="btn btn-outline-dark btn-sm m-1" name="btnViewPhoto" value='.$values["Id"].'>View</button>
                                                </form>
                                            </div>
                                        </div>
                                    ';
                                }
                            }
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <!-- ConfirmDelete Modal -->
        <div class="modal fade" id="ConfirmDeleteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Confirm Delete</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="Album.php" method="post" enctype="multipart/form-data">
                            <div class="row justify-content-center">
                                <div class="col-4">
                                    <button type="submit" class="btn btn-danger" id="btnDeleteAlbum" name="btnDeleteAlbum">Confirm</button>
                                </div>
                                <div class="col-4">
                                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <?php include("Shared/Footer.php") ?>
    </body>
</html>