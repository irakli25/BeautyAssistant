<?php

require_once("../classes/class.db.php");

$db = new DB();
$data = array();
$error = '';
$type = $_REQUEST['type'];

        $name  = $_REQUEST["name"];
        $surname  = $_REQUEST["surname"];
        $email = $_REQUEST["email"];
        $pass  = $_REQUEST["pass"];
        $pass  = md5($pass);

        $query = "SELECT * FROM `users` WHERE `email` = '$email'";

        $numrow = $db->numRows($query);

        if($numrow > 0){
            $error = "მომხმარებელი ამ ელფოსტით უკვე არსებობს !";
        }
        else{
            $query = "INSERT INTO users
                    SET `datetime` = NOW(),
                        `user_type_id` = '$type',
                        `name`  = '$name',
                        `surname`  = '$surname',
                        `email` = '$email',
                        `password` = '$pass' ";
            $result   =  $db->query($query);  
            $data['result'] = $result;
            $data['name']  = $name;  
        }
   
$data['Error'] = $error;
echo json_encode($data);
?>