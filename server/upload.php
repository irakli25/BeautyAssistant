<?php
require_once "../classes/class.db.php";
$db = new DB();

    $data = array();
    $error = "";

    if ( 0 < $_FILES['file']['error'] ) {
        $error = 'Error: ' . $_FILES['file']['error'] . '<br>';
    }
    else {
        $name = $_FILES["file"]["name"];
        $ext = end((explode(".", $name)));
        $rand_name = rand();
        $rand_file = $rand_name.".".$ext;
        move_uploaded_file($_FILES['file']['tmp_name'], 'uploads/'.$rand_file);
        $query = "INSERT INTO `file` SET `datetime` = NOW(), `name` = '$name', `rand_name` = '$rand_file'";
        $db->query($query);
        $id = $db->lastId();
        $data = array("status" => "Ok", "name" => $_FILES['file']['name'], "rand_name" => $rand_file,"link"=>'server/uploads/'.$rand_file, "id"=>$id);
    }

    $data['error'] = $error;
    echo json_encode($data);

?>