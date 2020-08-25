<?php


          ?>
          <form action="include/signupCode.php" method="post">

            <?php

            if (!empty($_GET["uid"])) {
              $display_block= '
              <div class="col-xs-o col-sm-10 col-sm-offset-1 col-md-10 col-md-offset-1 col-lg-8 col-lg-offset-2 ">

<h1>Account Registration</h1>
<input type="text" name="uid" placeholder="Username" value="'.$_GET["uid"].'"><br>';
            }
            else {
                $display_block= ' <div class="col-xs-o col-sm-10 col-sm-offset-1 col-md-10 col-md-offset-1 col-lg-8 col-lg-offset-2 ">

<h1>Account Registration</h1>
<input type="text" name="uid" placeholder="Username"><br>';
            }
          $display_block.="  <input type=\"password\" name=\"pass\" placeholder=\"Password\"><br>
            <input type=\"password\" name=\"pass-repeat\" placeholder=\"Repeat password\"><br>
            <button type=\"submit\" name=\"signup\">Signup</button><br>
          </form>";



            if (isset($_GET["error"])) {
                if ($_GET["error"] == "emptyfields") {
                    $display_block.='<p class="signuperror">Please fill in all of the fields!</p>';
                }

                else if ($_GET["error"] == "invaliduid") {
                    $display_block.= '<p class="signuperror">Invalid username!</p>';
                }

                else if ($_GET["error"] == "passwordcheck") {
                    $display_block.= '<p class="signuperror">Your passwords do not match!</p>';
                }
                else if ($_GET["error"] == "userExists") {
                    $display_block.= '<p class="signuperror">Username already exists!</p>';
                }
            }

            $display_block.='</div>';
            require "footer.php";

            ?>
