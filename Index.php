<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/all.css">
    <link rel="stylesheet" href="myCss/Css.css">

</head>
<body>
<div class="row">
    <div class="col-xs-o col-sm-10 col-sm-offset-1 col-md-10 col-md-offset-1 col-lg-8 col-lg-offset-2 ">
        <div class="center">
            <img src="Images/bannerstore.png" alt="Temp" class="responsive">
        </div>
        <nav class="navbar navbar-inverse">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>



            </button>
            <div class="navbar-brand">Menu</div>
            <div class="collapse navbar-collapse" id="myNavbar">
                <ul class="nav navbar-nav">

                    <li><a href="index.php">Home</a></li>
                    <li><a href="AboutUs.php">About Us</a></li>
                    <li><a href="ContactUs.php">Contact Us</a></li>
                    <li><a href="ourspecials.php">StorePage</a>
                    <?php
                    if(isset($_SESSION['acctype'])) {
                        if ($_SESSION['acctype'] == 'Admin') {
                            echo '<li><a href="AdminPage.php">Admin Options</a>';
                            echo '<li><a href="AdminComment.php">Comment Approval</a>';
                        }
                    }
?>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <?php
                    if(isset($_SESSION['uid'])) {
                        echo '<li><a>User : '.$_SESSION["uid"].'</a>
                        </li>';
                            echo '<li><a href="include/logoutCode.php">Log out</a></li>';

                    }else{
                        echo '<li><a href="loginPage.php">Login</a></li>';

                    }
                    ?>
                    <li><a href="showcart.php" id="cart"><i class="fas fa-shopping-cart"></i> Cart </a></li>
                </ul> <!--end navbar-right -->
            </div> <!--end container -->
        </nav>
    </div>
</div>

<div class="col-xs-o col-sm-10 col-sm-offset-1 col-md-10 col-md-offset-1 col-lg-8 col-lg-offset-2 ">
    <?php
    if (isset($_GET["msg"])) {
    if ($_GET["msg"] == "loginSuccesfull") {
            echo '<p>Login was completed Successfully</p>';
        }
        elseif ($_GET["msg"] == "logoutSucc") {
            echo '<p>Log out completed Successfully</p>';
        }
    }
    ?>
    <h2>XYZ Store</h2>
    <p> XYZ Store is an online only store. <br> We sell book and clothing. <br> But we aim to grow into more market as we mature. </p>
</div>
<div class="col-xs-o col-sm-10 col-sm-offset-1 col-md-10 col-md-offset-1 col-lg-8 col-lg-offset-2 ">



<footer class="col-xs-o col-sm-10 col-sm-offset-1 col-md-10 col-md-offset-1 col-lg-8 col-lg-offset-2 ">
    <p class="text-center">Created by: Christos</p>

</footer>
</body>

<script src="https://use.fontawesome.com/c0ae1644e6.js"></script>
<script src="js/jquery-3.2.0.min.js"></script>
<script src="js/bootstrap.min.js"></script>
</html>