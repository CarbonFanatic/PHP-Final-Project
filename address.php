<?php
session_start();
if(isset($_COOKIE['paymentinfo'])){
    $data = unserialize($_COOKIE['paymentinfo']);
    }
else $data=null;

?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/all.css">

    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="myCss/Css.css">
    <style>
        .smalls{
            margin-top: 3%;

            margin-right: 10%;
            float:right;
        }
    </style>
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
                    <li><a href="OurSpecials.php">StorePage</a></li>
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
<div class="col-xs-o col-sm-10 col-sm-offset-1 col-md-10 col-md-offset-1 col-lg-8 col-lg-offset-2">
<h2> Please Enter Your Address </h2>
<form action="invoice.php" method='post'>
<span>Street number & name</span>  <input type='text' name='street' required value="<?php echo $data['street']?>" ><br>
<span>City</span> <input type='text' name='city' required value="<?php echo $data['city']?>"><br>
<span>Province</span> <input type='text' name='province' required value="<?php echo $data['province']?>"><br>
<h2>Please enter you Name</h2>
<span>First Name</span> <input type='text' name='fname' required value="<?php echo $data['fname']?>"><br>
<span>Last Name</span> <input type='text' name='lname' required value="<?php echo $data['lname']?>"><br>
<h2>Please enter you payment info</h2>
<span>Card Holder Name:</span> <input type='text' name='cardname' required value=<?php echo $data['cardname']?>><br>
<span>Card Type</span> <br>
<fieldset id='Card'>

<input type='radio' name='typeCard' value='Visa' checked><span>Visa</span>
     <input id='radio_f' type='radio' name='typeCard' value='Master'><span>Master Card</span><br>
</fieldset>

<span>Card Number:</span> <input type="number" name='cardNumber' required value="<?php echo $data['cardNumber']?>"><br>
<span>Expiration Date (mm/yy):</span> <input type='text' name='expdate' required value="<?php echo $data['expdate']?>"><br>
<span>CVV:</span> <input type="number" name='cvv' required value="<?php echo $data['cvv']?>"><br>

 </p>
 <p><u>Please select your preferred shipping method</u></p>
   <fieldset id='shipping'>
        <input type='radio' name='type' value='Standard' checked><span>Standard Shipping (2-5) day $9.99</span><br>
        <input id='radio_f' type='radio' name='type' value='Expedited' <?php if($data['type']==='Expedited') echo 'checked';?>>

    <span>Expedited Shipping (1-3) days $19.99</span><br>
        </fieldset>
      <button type="submit">Create invoice</button>
</form>




            </div>
</body>
<script src="https://use.fontawesome.com/c0ae1644e6.js"></script>
<script src="js/jquery-3.2.0.min.js"></script>
<script src="js/bootstrap.min.js"></script>
</html>
