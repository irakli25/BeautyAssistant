<?php

require_once("../classes/class.db.php");

$db = new DB();
$data = array();
$error = '';
$action = $_REQUEST['action'];

switch ($action){
    case 'client' :  break;
    case 'staff'  :  break;
    default : $error = "Error 404 Action is null";
}

$data['Error'] = $error;
echo json_encode($data);
?>