<?php session_start(); 
    include("Services/PhotoService.php");
    if (!isset($_COOKIE["UserId"])) {
        header("Refresh:0;url=index.php");
    } 
?>
<?php
    $ShowAlert = false;
    if (isset($_POST["btnLike"])) {
        $checkLike = GetLikeByStatusIdAndUserId($_POST["btnLike"], $_COOKIE["UserId"]);
        if ($checkLike == null) {
            $like = CreateLike($_POST["btnLike"], $_COOKIE["UserId"]);
            $status = GetStatusById($_POST["btnLike"]);
            $uStatus = UpdateStatus($status['Id'], $status['Status'], $status['NumberOfLikes'] + 1);
            
            if ($like == null) {
                echo '
                    <script>alert("problem inserting in like")</script>
                ';
            }
        } else {
            $ShowAlert = true;
        }
        
    }
?>
<?php
    $allStatus = GetAllStatus();
    $photos = array();
    $users = array();
    foreach ($allStatus as $key => $value) {
        # code...
        $photos[] = GetPhotoById($value['PhotoId']);
        $users[] = GetUserById($value['UserId']);
    }
    
    //Debug($photos);
    //Debug($allStatus);
?>


<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>TimeLine</title>
        <!-- CSS only -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
        <style>
            
            .container{
                position: relative;
                text-align: center;
                color: black;
            }
            
        </style>
        <style>
            .image-thumbail {
                height: 200px;
                width: 300px;
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
        <div class="container w-100 justify-content-center">
            <div class="row">
                <div class="col">
                <?php 
                    if ($ShowAlert) {
                        echo '
                            <div class="alert alert-danger" role="alert">
                          You can like a status at once!
                        </div>
                        ';
                    }
                    $iter = 0;
                    foreach ($allStatus as $key => $value) {
                        # code...
                        echo '
                            
                            <div class="card my-2">
                                <div class="card-header">
                                    <div>'.$users[$iter]["FirstName"].' '.$users[$iter]["LastName"].' posted a photo at '.$value["CreatedAt"].'</div>
                                    
                                </div>
                                <div class="card-body">
                                    <p>'.$value['Status'].'</p>
                                    <img class="image-thumbail" src="'.$photos[$iter]["Path"].'" alt="Card image cap">
                                </div>
                                <div class="card-header">
                                    <div class="row">
                                        <div class="col">
                                        <form method="post" action="TimeLine.php">
                                            <button class="btn btn-white" name="btnLike" value='.$value["Id"].'> Like </button>
                                        </form>
                                        <p>'.$value["NumberOfLikes"].' People Liked It.</p>
                                    </div>
                                        <div class="col">
                                            <form method="post" action="Comments.php">
                                                <button class="btn btn-white" name="btnComments" value='.$value["Id"].'>Comments</button>
                                            </form>
                                            
                                        </div>
                                    </div>
                                </div>
                                
                                
                            </div>      
                            
                        ';
                        $iter++;
                    }
                 ?>
                 </div>
            </div>
        </div>
        <?php include("Shared/Footer.php") ?>

    </body>
</html>