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

            if($type == "1"){
                $query = "SELECT SUBSTRING(MD5(now()), 1, 3) AS `md`";
                $result = $db->query($query);
                $result1 = $result->fetch_assoc();
                $query =  "SELECT SUBSTRING(MD5('$email'), 1, 3) AS `md`";
                $result = $db->query($query);
                $result2 = $result->fetch_assoc();
                $uid = $result1['md'].'$'.$result2['md'];

            }
            else{
                $uid = 'client'; 
            }

            $query = "INSERT INTO users
                    SET `datetime` = NOW(),
                        `uid`      = '$uid',
                        `user_type_id` = '$type',
                        `name`  = '$name',
                        `surname`  = '$surname',
                        `email` = '$email',
                        `password` = '$pass' ";
            $result   =  $db->query($query);  
            if($result){
                $_SESSION['USER'] = $db->lastId();
                $_SESSION['USER_NAME'] = $name;
            }

            $data['result'] = $result;
            $data['name']  = $name;  
            $data['email']  = $email;  
        }
   
$data['Error'] = $error;
echo json_encode($data);
?>