<?php

//credentials
$servername= "localhost";
$username="root";
$password="";
$dbname="iotlab5";

//connect to the data base
$con = mysqli_connect($servername,$username,$password,$dbname);

//get the parametrs: get

$tankid=$_GET['TankID'];
$locationid=$_GET['LocationID'];
$ownerid=$_GET['OwnerID'];
$waterlevel=$_GET['WaterLevel'];

//create querry
$sql = "INSERT INTO waterlevel (TankID, LocationID, OwnerID, WaterLevel) VALUES ('{$tankid}','{$locationid}','{$ownerid}','{$waterlevel}')";

if (mysqli_query($con, $sql)) 
echo "New Water Level record created successfully";

?>