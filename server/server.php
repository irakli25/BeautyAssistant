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

    case "get_products":
        $exp = $_REQUEST['exps'];

        if (is_array($exp)){
            $expe = implode(",",$exp);
        }
        else{
            $expe = $exp;

        }

        $query = "SELECT `name` FROM experience WHERE id  IN ($expe)";

        $res = $db->query($query);
        $arr_string = array();
        while($arr = $res->fetch_assoc()){
            array_push($arr_string, $arr['name']);
        }

        $data = array("products" => implode(',',$arr_string));

    break;
    case "get_address":
        $id = $_SESSION['USER'];
        $district = $_REQUEST['district'];
        $query = "SELECT `district_id` FROM `user_district` WHERE `user_id` = '$id' LIMIT 1 ";
        $res = $db->query($query);
        $arr = $res->fetch_assoc();
        $street = '';
        if($district == $arr['district_id']){
            $query = "SELECT `street_id` FROM `user_street` WHERE `user_id` = '$id' LIMIT 1 ";
            $res = $db->query($query);
            $arr = $res->fetch_assoc();
            $street = $arr['street_id'];

            $query = "SELECT `client_correct_address` AS `name` FROM `users` WHERE `id` = '$id' LIMIT 1 ";
            $res = $db->query($query);
            $arr = $res->fetch_assoc();
            $street_name = $arr['name'];

            $data = array("isaddress" => true, "street" => $street, "street_name" => $street_name);
        }
        else{
            $data = array("isaddress" => false, "street" => "");
        }

    break;

}

$data["error"] = $Error;
echo json_encode($data);


?>