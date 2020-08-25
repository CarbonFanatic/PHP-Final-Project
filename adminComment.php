<?php
session_start();
include("include/DBConn.inc");
require("include/Product.php");
include ("include/include.php");
$styles="  <style>
        .smalls{
            font-size: 20px;
            margin-right: 10%;
            float:right;
        }
        span{
            font-size: 20px;

        }

    </style>";
$display_block = "<div class=\"col-xs-o col-sm-10 col-sm-offset-1 col-md-10 col-md-offset-1 col-lg-8 col-lg-offset-2 \">

<h1>Comments</h1>";
if(isset($_SESSION['acctype'])) {
    if ($_SESSION['acctype'] != 'Admin') {
        $display_block .= 'To view Comments please log into an admin account';
    } else {
        $display_block .= "
    <table celpadding=\"3\" cellspacing=\"2\" border=\"1\" width=\"100%\">
    <tr>
    <th>Title</th>
    <th>UserName</th>
    <th>color</th>
    <th>Size</th>
    <th>Comment</th>
    <th>Status</th>  
     <th>Action</th>

    
    
    </tr>";
        $xml= simplexml_load_file("include/comment.xml");

        foreach ($xml as $item){
                $display_block.= "
<tr>
  	    <td align=\"center\">$item->name </td>
 	    <td align=\"center\">$item->uid </td>
 	    <td align=\"center\">$item->color </td>
 	    <td align=\"center\">$item->size </td>
 	    <td align=\"center\">$item->comment</td>
 	    <td align=\"center\"> $item->Approval</td>
        <td align=\"center\"><a href=\"include/appDenyComment.php?status=Approve&comment=".$item->comment."\"><button type=\"button\">Approve</a><a href=\"include/appDenyComment.php?status=Deny&comment=".$item->comment."\"><button type=\"button\">Deny</a></td>	
          </tr>";


            }

        }


}

require "footer.php";

?>

