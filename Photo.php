<?php session_start(); 
    include("Services/PhotoService.php");
    if (!isset($_COOKIE["UserId"])) {
        header("Refresh:0;url=index.php");
    } 
    if (!isset($_SESSION["PhotoId"])) {
        header("Refresh:0;url=Album.php");
    }
?>
<?php 
    $photo = null;
    $album = null;
    $albums = null;
    if (isset($_SESSION["PhotoId"])) {
        $photo = GetPhotoById($_SESSION["PhotoId"]);
        if ($photo != null) {
            $album = GetAlbumById($photo["AlbumId"]);
        }
        $albums = GetAlbumsByUserId($_COOKIE["UserId"]);
    }
?>
<?php 
    if (isset($_POST["btnSavePhoto"])) {
        $photo = UpdatePhoto($_SESSION["PhotoId"], $_POST["title"], $_POST["description"], $_POST["selectedAlbum"]);
        $album = GetAlbumById($photo["AlbumId"]);
    }
?>
<?php 
    if (isset($_POST["btnDeletePhoto"])) {
        $photo = DeletePhotoById($_SESSION["PhotoId"]);
        unset($_SESSION["PhotoId"]);
        header("Refresh:0;url=Album.php");
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset='utf-8'>
        <meta http-equiv='X-UA-Compatible' content='IE=edge'>
        <title>Photo</title>
        <meta name='viewport' content='width=device-width, initial-scale=1'>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    </head>
    <body>
        <?php include("Shared/Navbar.php") ?>
        <div class="container m-4">
            <div class="row justify-content-center">
                <div class="col-md-7">
                    <a href="Album.php" class="btn btn-dark my-3">Go Back</a>
                    <div style="height: 90vh;">
                        <?php 
                            if ($photo != null) {
                                echo '
                                    <a href='.$photo["Path"].'><img style="max-width: 100%; max-height: 100%;" src='.$photo["Path"].'>
                                    </a>
                                ';
                            } else {
                                echo "<h4>No photos</h4>";
                            }
                        ?>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-md-8">
                                    <h4>Photo Details</h4>
                                </div>
                                <div class="col">
                                    <button class="btn" data-bs-toggle="modal" data-bs-target="#EditPhotoDetailsModal"><i class="fa fa-edit"></i></button>
                                    <button class="btn" name="ConfirmDeleteModal" data-bs-toggle="modal" data-bs-target="#ConfirmDeleteModal"><i class="fa fa-trash"></i></button>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <ul class="list-group list-group-flush">
                                <?php 
                                    if ($photo != null) {
                                        echo '
                                            <li class=" list-group-item">
                                                <div>
                                                    <b>Photo Title : </b> '.$photo["Title"].'
                                                </div>
                                            </li>
                                            <li class=" list-group-item">
                                                <div>
                                                    <b>Album Title</b> : '.$album["Title"].'
                                                </div>
                                            </li>
                                            <li class=" list-group-item">
                                                <div>
                                                    <b>Uploaded at</b> : '.$photo["CreatedAt"].'
                                                </div>
                                            </li>
                                            <li class=" list-group-item">
                                                <div>
                                                    <b>Description</b> : '.$photo["Description"].'
                                                </div>
                                            </li>
                                        ';
                                    }
                                ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- EditPhotoDetailsModal -->
        <div class="modal fade" id="EditPhotoDetailsModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Edit Photo Details</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="Photo.php" method="post" enctype="multipart/form-data">
                            <?php 
                                echo '
                                    <div class="mb-3">
                                        <label class="form-label">Photo Title</label>
                                        <input type="text" class="form-control" id="title" name="title" value='.$photo["Title"].'>
                                    </div>
                                ';
                            ?>
                            <div class="mb-3">
                                <label>Select a album</label>
                                <select name="selectedAlbum" class="form-control">
                                    <?php 
                                        echo '
                                            <option value='.$album["Id"].'>'.$album["Title"].'</option>
                                        ';
                                    ?>
                                    <?php 
                                        foreach ($albums as $key => $values) {
                                            echo '
                                                <option value='.$values["Id"].'>'.$values["Title"].'</option>
                                            ';
                                        }
                                    ?>
                                </select>
                            </div>
                            <?php 
                                echo '
                                    <div class="mb-3">
                                        <label class="form-label">Description</label>
                                        <input type="text" class="form-control" id="description" name="description" value='.$photo["Description"].'>
                                    </div>
                                ';
                            ?>
                            <button type="submit" class="btn btn-dark" id="btnSavePhoto" name="btnSavePhoto">Save</button>
                        </form>
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
                        <form action="Photo.php" method="post" enctype="multipart/form-data">
                            <div class="row justify-content-center">
                                <div class="col-4">
                                    <button type="submit" class="btn btn-danger" id="btnDeletePhoto" name="btnDeletePhoto">Confirm</button>
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