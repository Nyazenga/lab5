<?php
    $servername= "localhost";
    $username="root";
    $password="";
    $dbname="iotlab5";
    $con = mysqli_connect($servername,$username,$password,$dbname);

    $data=array();        

    $q=mysqli_query($con,"select WaterLevel from waterlevel ORDER BY WaterLevelID DESC LIMIT 1");    
    
    $row=mysqli_fetch_object($q);
    while ($row)
    {         
        echo " {$row->WaterLevel}";
        $row=mysqli_fetch_object($q);
    }       
?>

