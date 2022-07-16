<?php session_start(); 
    include("Services/PhotoService.php");
?>
<?php 
    $userProfile = GetUserById($_COOKIE["UserId"]);
?>
<?php 
    if (isset($_POST["btnEditProfile"])) {
        if ($userProfile["Password"] != $_POST["oldPassword"]) {
            echo '
                <script>alert("Your password is incorrect!!")</script>
            ';
        } else {
            if ($_POST["newPassword"] != '' || $_POST["confirmNewPassword"] != '') {
                if ($_POST["newPassword"] != $_POST["confirmNewPassword"]) {
                    echo '
                        <script>alert("Your password does not match!!")</script>
                    ';
                } else {
                    $userProfile = UpdateUser($_COOKIE["UserId"], $_POST["firstName"], $_POST["lastName"], $_POST["newPassword"]);
                    echo '
                        <script>alert("Profile updated successfully!!")</script>
                    ';
                }
            } else {
                $oldPassword = $userProfile["Password"];
                $userProfile = UpdateUser($_COOKIE["UserId"], $_POST["firstName"], $_POST["lastName"], $oldPassword);
                echo '
                    <script>alert("Profile updated successfully!!")</script>
                ';
            }
        }
        if ($userProfile == null) {
            Debug("ERROR to update profile");
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Profile</title>
        <!-- CSS only -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    </head>
    <body>
        <?php include("Shared/Navbar.php") ?>
        <div class="container m-5">
            <div class="row justify-content-center">
                <div class="col-md-5">
                    <div class="card">
                        <div class="card-header">
                            <h5>Edit User Profile</h5>
                        </div>
                        <div class="card-body">
                            <form class="form-group" method="post" action="Profile.php" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label class="form-label">First Name</label>
                                    <?php 
                                        echo '
                                            <input required type="text" class="form-control" id="firstName" name="firstName" value='.$userProfile["FirstName"].'>
                                        ';
                                    ?>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Last Name</label>
                                    <?php 
                                        echo '
                                            <input type="text" class="form-control" id="lastName" name="lastName" value='.$userProfile["LastName"].'>
                                        ';
                                    ?>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Email address</label>
                                    <?php 
                                        echo '
                                            <input type="email" class="form-control" id="email" name="email" disabled="true" value='.$userProfile["Email"].'>
                                        ';
                                    ?>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Old Password</label>
                                    <input type="password" class="form-control" id="oldPassword" name="oldPassword" required>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">New Password</label>
                                    <input type="password" class="form-control" id="newPassword" name="newPassword">
                                </div>
                                <div class="form-group">
                                    <label class="form-label"> Confirm New Password</label>
                                    <input type="password" class="form-control" id="confirmNewPassword" name="confirmNewPassword">
                                </div>
                                <button type="submit" class="btn btn-dark m-3" id="btnEditProfile" name="btnEditProfile">Edit Profile</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php include("Shared/Footer.php") ?>
    </body>
</html>