<?php session_start(); 
    include("Services/PhotoService.php");
?>
<?php 
    if (isset($_POST['btnSignUp'])) {
        if ($_POST['password'] != $_POST['confirmPassword']) {
            echo "
                <script>alert('Password mis matched.')</script>
            ";
        } else {
            $user = CreateUser($_POST['firstName'],$_POST['lastName'],$_POST['email'],$_POST['password']);
            if ($user == null) {
                echo "
                    <script>alert('Please check the given data.')</script>
                ";
            } else {
            $expiredTime = time() + (86400 * 30);
            setcookie("UserId", $user["Id"], $expiredTime, "/");
            header("Refresh:0");
            }
        }
    }
?>
<?php 
    if (isset($_POST['btnLogIn'])) {
        //Debug($_POST['btnLogIn']);
        $user = GetUserByEmail($_POST['email']);
        if ($user == null) {
            echo "
                <script>alert('No User Found')</script>
            ";
        } else {
            if ($user["Password"] != $_POST['password']) {
                echo "
                    <script>alert('Password Mis matched')</script>
                ";
            } else { 
                $expiredTime = time() + (86400 * 30);
                setcookie("UserId", $user["Id"], $expiredTime, "/");
                header("Refresh:0");
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Home</title>
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
            .container{
                position: relative;
                text-align: center;
                color: white;
            }
            .centered {
                position: absolute;
                top: 30%;
                left: 50%;
                transform: translate(-50%, -50%);
            }
        </style>
    </head>
    <body>
        <?php include("Shared/Navbar.php") ?>
        <div class="container">
            <img style="max-width: 100%; max-height: 100%;" src="Assets/Images/index.jpg" >
            <div class="centered">
                <h1>Welcome to Online Photo Album</h1>
                <h4>Please signup and login for create album and upload photos.</h4>
            </div>
        </div>
        <!-- Log In Modal -->
        <div class="modal fade" id="LogInModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Log In</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="" method="post" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label class="form-label">Email address</label>
                                <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp">
                                <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Password</label>
                                <input type="password" class="form-control" id="password" name="password">
                            </div>
                            <button type="submit" class="btn btn-dark" id="btnLogIn" name="btnLogIn">Log In</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Sign Up Modal -->
        <div class="modal fade" id="signUpModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Sign Up</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="" method="post" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label class="form-label">First Name</label>
                                <input type="text" class="form-control" id="firstName" name="firstName" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Last Name</label>
                                <input type="text" class="form-control" id="lastName" name="lastName">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Email address</label>
                                <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp" required>
                                <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Password</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label"> Confirm Password</label>
                                <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" required>
                            </div>
                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input" id="checkBox" name="checkBox" required>
                                <label class="form-check-label">Check me out</label>
                            </div>
                            <button type="submit" class="btn btn-dark" id="btnSignUp" name="btnSignUp">Sign Up</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <?php include("Shared/Footer.php") ?>
    </body>
</html>