<?php 

require('../model/tanks.php');

$db = new Database();

if(isset($_POST['action']) && $_POST['action']== "view"){
    $output = '';
    $data = $db->read();
   //  print_r($data);
    if($db->totalRowCount()>0){ 
        $output .= '<table class="table table-striped table-sm table-bordered">
        <thead>
            <tr class="text-center">
                <th>Tank ID</th>
                <th>Tank Name</th>
            </tr>
        </thead>
        <tbody>
        ';
        foreach($data as $row){
            $output .= '<tr class="text-center text-secondary">
            <td>'.$row['TankID'].'</td>
            <td>
            <a href="waterlevel-entries.php?id='.$row['TankID'].'">
            '.$row['Tank'].'</a>
            </td>
            </tr>';
        }
        $output .='</tbody></table>';
        echo $output;
    }else{
        echo '<h3 class="text-center text-secondary mt-5">:( no any user present in the database )</h3>';
    }
}

//insert a tank
if(isset($_POST['action']) && $_POST['action'] == "insert"){
    $user_id = $_POST['user_id'];
    $tank_name = $_POST['tank_name'];
    $db->insert($user_id, $tank_name); 
}

if(isset($_POST['edit_id'])){
    $id = $_POST['edit_id'];

    $row = $db->getTankBiId($id);
    echo json_encode($row);
}

if(isset($_POST['action']) && $_POST['action'] == 'update'){
    $id = $_POST['id'];
    $user_id = $_POST['user_id'];
    $tank_name = $_POST['tank_name'];
    $db->update($id,$user_id, $tank_name);
}





if(isset($_POST['del_id'])){
    $id = $_POST['del_id'];

    $db->delete($id);
}

if(isset($_POST['info_id'])){
    $id = $_POST['info_id'];
    $row = $db->getTankBiId($id);
    echo json_encode($row);
}


if(isset($_GET['export']) && $_GET['export'] == "excel"){
    header("Content-Type: application/xls");
    header("Content-Disposition: attachment; filename=tanks.xls");
    header("pragma: no-cache");
    header("Expires: 0");

    $data = $db->read();
    echo '<table border="1">';
    echo '<tr><th>Tank ID</th><th>Tank Name</th>';

    foreach($data as $row){
        echo '<tr>
        <td>'.$row['TankID'].'</td>
        <td>'.$row['Tank'].'</td>
        </tr>';
    }
    echo '</table>';
}
