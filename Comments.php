<?php session_start(); 
    include("Services/PhotoService.php");
    if (!isset($_COOKIE["UserId"])) {
        header("Refresh:0;url=index.php");
    } 
?>
<?php 
    
    if(isset($_POST["btnComments"])) {
        $_SESSION["StatusId"] = $_POST["btnComments"];
    }
 ?>
 <?php 
    if (isset($_POST["btnAddComment"])) {
        $comment = CreateComment($_POST["comment"],$_SESSION["StatusId"],$_COOKIE["UserId"]);
        if ($comment == null) {
            echo '
                <script>alert("Comment adding error")</script>
            ';
        }
    }
  ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Comments</title>
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
        </style>
    </head>
    <body>
        <?php include("Shared/Navbar.php") ?>
        <div class="container">
            <div class="text-center">
                <?php 
                    $status = GetStatusById($_SESSION["StatusId"]);
                    $whoShared = GetUserById($status["UserId"]);
                    $photo = GetPhotoById($status["PhotoId"]);
                    echo'
                        <div class="card w-100 h-100 my-2 ">
                                <div class="card-header">
                                    <div>'.$whoShared["FirstName"].' '.$whoShared["LastName"].' posted a photo at '.$status["CreatedAt"].'</div>
                                    
                                </div>
                                <div class="card-body">
                                    <p>'.$status['Status'].'</p>
                                    <img class="image-thumbail" src="'.$photo["Path"].'" alt="Card image cap">
                                </div>
                                
                                
                            </div>      
                    ';
                 ?>
            </div>
        </div>
        <div class="container ">
            <div class="card w-100 d-flex align-items-center justify-content-center">
                    <div class="card-body">
                            <div class="row d-flex align-items-center justify-content-center">
                                <form action="Comments.php" method="post" enctype="multipart/form-data">
                                    <div class="mb-3">
                                        <label class="form-label">Add New Comment</label>
                                        <input type="text" class="form-control" id="comment" name="comment">
                                    </div>
                                    <div class="row">
                                        <div class="col-7">
                                        <button type="submit" class="btn btn-success" id="btnAddComment" name="btnAddComment">Add Comment</button>
                                    </div>
                                    <div class="col-4">
                                        <a class="btn btn-primary" aria-label="Close" href="Timeline.Php">Go back</a>
                                    </div>
                                    </div>
                                    
                                </form>
                                <ol class="list-group list-group my-2 d-flex align-items-center justify-content-center">
                                    <?php 
                                        $comments = GetCommentsByStatusId($_SESSION["StatusId"]);
                                        if ($comments != null) {
                                            foreach ($comments as $key => $value) {
                                                # code...
                                                    $whoCommented = GetUserById($value["WhoCommented"]);

                                                echo '
                                                    <li class="list-group-item d-flex justify-content-between">
                                                        <div class="ms-2 me-auto">
                                                          <div class="fw-bold">'.$whoCommented["FirstName"].' commented at '.$value["CreatedAt"].'</div>
                                                            <p>'.$value["Comment"].'</p>
                                                          
                                                        </div>
                                                      </li>
                                                ';
                                            }
                                        }
                                        
                                     ?>
                                  <!-- <li class="list-group-item d-flex justify-content-between align-items-start">
                                    <div class="ms-2 me-auto">
                                      <div class="fw-bold">Subheading</div>
                                      Content for list item
                                    </div>
                                    <span class="badge bg-primary rounded-pill">14</span>
                                  </li>
                                  <li class="list-group-item d-flex justify-content-between align-items-start">
                                    <div class="ms-2 me-auto">
                                      <div class="fw-bold">Subheading</div>
                                      Content for list item
                                    </div>
                                    <span class="badge bg-primary rounded-pill">14</span>
                                  </li>
                                  <li class="list-group-item d-flex justify-content-between align-items-start">
                                    <div class="ms-2 me-auto">
                                      <div class="fw-bold">Subheading</div>
                                      Content for list item
                                    </div>
                                    <span class="badge bg-primary rounded-pill">14</span>
                                  </li> -->
                                </ol>
                                
                                
                            </div>
                    </div>
                </div>
        </div>
        <?php include("Shared/Footer.php") ?>
    </body>
</html>