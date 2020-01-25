<?php
require_once("../classes/class.db.php");
session_start();
$action = $_REQUEST['act'];
$Error  = "";

$data = array();
$db = new DB();

switch ($action){

    case "get_list_staff" :
        $html = "";
        $query = "SELECT  `users`.`name`, 
                `users`.`surname`,  
                `users`.`about` ,
                `users`.`uid`,
                `file`.`rand_name` AS `img`
                from users
                LEFT JOIN  file ON file.id = `users`.img
                WHERE `users`.`user_type_id` = 1 AND active = 1";
        $res = $db->query($query);
        while($arr = $res->fetch_assoc()){
            $html .= '
            <div class="profile" link = "?route=7&uid='.$arr['uid'].'">
					<div class="profile_image shadow" style="background-image:url(\'server/uploads/'.$arr['img'].'\')"></div>
					<div class="profile_text">
						<h4>'.$arr['name'].' '.$arr['surname'].'</h4>
						<p>'.$arr['about'].'</p>
					</div>
			</div>
            ';
        }
        $data = array("html"=>$html);

    break;

    case "get_mail":
        $id = $_SESSION['USER'];
        $query = "SELECT `email` FROM `users` WHERE `id` = '$id' ";
        $res = $db->query($query);
        $arr = $res->fetch_assoc();
        $data = array("email"=>$arr['email']);
    break;

}

$data["error"] = $Error;
echo json_encode($data);


?>