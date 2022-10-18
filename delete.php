<?php

//credentials
$servername= "localhost";
$username="root";
$password="";
$dbname="iotdemo1";

//connect to the data base
$con = mysqli_connect($servername,$username,$password,$dbname);

//get the parametrs: get,post, put, request

$tempID=$_GET['tempID'];
$temperature=$_GET['temperature'];
$groupName=$_GET['groupName'];

//create querry

$sql = "delete from tempdata where tempID={$_GET['tempID']}";
//echo $sql;

if (mysqli_query($con, $sql)) 
echo "New record deleted successfully";

mysqli_query($con, $sql);

$data=array(); 
$q=mysqli_query($con,"select * from tempdata "); 
echo "<table>
<tr> <th> ID of sensor </th>
<th> Temperature </th>
<th>Group </th> </tr>";
while ($row=mysqli_fetch_object($q))
{ 
echo "<tr> <td>{$row->tempID}</td> <td>{$row->temperature}</td> 
<td>{$row->groupName} </td> </tr>";
} 
echo "</table>";
?>