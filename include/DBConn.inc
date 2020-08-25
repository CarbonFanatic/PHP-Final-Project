<?php
//connect to database
$conn = new mysqli('localhost', 'root', '', 'Storefront','3308');
if ($conn->connect_error){
	echo "Connect failed: $conn->connect_error";
}
?>