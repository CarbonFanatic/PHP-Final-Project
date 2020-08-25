<?php
$display_block = "<div class=\"col-xs-o col-sm-10 col-sm-offset-1 col-md-10 col-md-offset-1 col-lg-8 col-lg-offset-2 \">";

if (isset($_GET["msg"])) {
    if ($_GET["msg"] == "accountCreated") {
        $display_block.='<p>Account Succefully Created</p>';
    }
    elseif ($_GET["msg"] == "emptyfields") {
        $display_block.='<p>Please fill out both your Username and Password</p>';
    }
    elseif ($_GET["msg"] == "UserNExist") {
        $display_block.='<p>User does not exist, Please sign up</p>';
    }
    elseif ($_GET["msg"] == "wrongPassword") {
        $display_block.='<p>You Have Enetered The Wrong Password</p>';
    }


}
    $display_block.= '<form action="include/loginCode.php" method="post">';

if (!empty($_GET["uid"])) {
    $display_block.= '<input type="text" name="uid" placeholder="Username" value="'.$_GET["uid"].'">';
}
else {
    $display_block.='<input type="text" name="uid" placeholder="Username">';
}

$display_block.='
    <input type="password" name="pass" placeholder="Password">
    <button type="submit" name="login">Login</button>
</form>
<a href="signup.php"">Signup</a>';

$display_block.="</div>";
require "footer.php";




?>