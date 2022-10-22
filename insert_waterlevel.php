<?php

//credentials
$servername= "localhost";
$username="root";
$password="";
$dbname="iotlab3";

//connect to the data base
$con = mysqli_connect($servername,$username,$password,$dbname);

//get the parametrs: get

$temperature=$_GET['temperature'];

//create querry
$sql = "INSERT INTO tempdata (temperature) VALUES ('{$temperature}')";

if (mysqli_query($con, $sql)) 
echo "New temperature record created successfully";

?>