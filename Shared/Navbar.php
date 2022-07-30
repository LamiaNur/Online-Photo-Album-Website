<nav class="navbar navbar-expand-lg  navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="index.php">PhotoAlbum</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav col-md-9">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="index.php">Home</a>
                </li>
                <?php 
                    if (isset($_COOKIE["UserId"])) {
                        echo '
                            <li class="nav-item">
                                <a class="nav-link" href="Album.php">Albums</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" aria-current="page" href="Timeline.php">Timeline</a>
                            </li>
                        ';
                    }
                ?>
            </ul>
            <ul class="navbar-nav col">
                <?php 
                    if (!isset($_COOKIE["UserId"])) {
                        echo '
                            <li class="nav-item">
                                <button type="button" class="btn btn-light" data-bs-toggle="modal" data-bs-target="#LogInModal">Log In</button>   
                            </li>
                            <li class="nav-item mx-2">
                                <button type="button" class="btn btn-light" data-bs-toggle="modal" data-bs-target="#signUpModal">Sign Up</button>   
                            </li>
                        ';
                    } else {
                        $user = GetUserById($_COOKIE["UserId"]);
                        echo '
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                '.$user["FirstName"].'</a>
                                <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                    <li><a class="dropdown-item" href="Profile.php">Account Settings</a></li>
                                    <li>
                                        <form method="post" action="index.php">
                                            <button class="dropdown-item" name="btnLogOut">Log Out</button>
                                        </form>
                                    </li>
                                </ul>
                            </li> 
                      `';
                    }
                    if (isset($_POST["btnLogOut"])) {
                        setcookie("UserId", "", time() - 3600, "/");
                        session_destroy();
                        header("Refresh:0");
                    }
                ?>
            </ul>
        </div>
    </div>
</nav>