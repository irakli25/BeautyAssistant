<?php

require_once "../../classes/class.db.php";
session_start();
$action = $_REQUEST['act'];
$Error  = "";
$data = array();
$db = new DB();
error_reporting(E_ALL);
ini_set('display_errors', 1);
switch($action){

    case "update_user" :
        $name = $_REQUEST['id'];
        $user_id = $_SESSION['USER'];
        $value   = $_REQUEST['value'];

        $query = "UPDATE `users`
                        SET `$name` = '$value'
                        WHERE `id`  = '$user_id'
        
        ";
        $result   =  $db->query($query); 
        $data = array("result" => $result);
    break;
    case "update_phones" :
        $id = $_SESSION['USER'];

        $result = get_phones($id);
        $data = array("result" => $result);
    break;
    case "add_phone" :
        $id = $_SESSION['USER'];
        $number = $_REQUEST['number'];
        $query = "INSERT INTO `phones`
                    SET `user_id` = '$id',
                        `datetime`=now(),
                        `phone`   = $number

        
        ";
        $result   =  $db->query($query); 
        $data = array("result" => $result);
    break;
    case "delete_phone" :
            $id = $_REQUEST['id'];
            $query = "UPDATE `phones`
                        SET `active` = 0
                        WHERE `id` = '$id'

            
            ";
            $result   =  $db->query($query); 
            $data = array("result" => $result);
    break;
    case "update_district" :
        $ids = $_REQUEST['ids'];
        $user_id = $_SESSION['USER'];
        $query = "DELETE FROM `user_district` WHERE `user_id` = '$user_id'";
        $db->query($query);
        foreach($ids as $id){
            $query = "INSERT INTO `user_district` SET `district_id` = '$id', `user_id` = '$user_id', `datetime` = NOW()";
            $db->query($query);
        }
    break;
    case "get_district":
        $user_id = $_REQUEST['user_id'];
        $arr = array();
        $query = "SELECT `district_id` AS `id` FROM `user_district` WHERE `user_id` = '$user_id'";
        $res = $db->query($query);
        while ($r = $res->fetch_assoc()){
            array_push($arr,$r['id']);
        }
        $data = array("arr" => $arr);
    break;
    case "save_portfolio" :
        $user_id = $_SESSION['USER'];
        $file_id = $_REQUEST['id'];
        $query = "INSERT INTO `portfolio` SET `datetime` = NOW(), `file_id` = '$file_id', `user_id` = '$user_id' ";
        $db->query($query);
        $html = "";
        $query = "SELECT `file`.`rand_name`  
                FROM `portfolio` 
                JOIN `file` ON `portfolio`.`file_id` = `file`.`id`
                WHERE `portfolio`.`active` = 1 AND `portfolio`.`user_id`=" . $user_id;
        $res = $db->query($query);
        while($result = $res->fetch_assoc()){
            $html .= '<div class="portfolio-pic" style="background-image:url(\'server/uploads/'.$result['rand_name'].'\')"></div>';
        }
        $html .='<div id ="up_pic_port" class="portfolio-add" ><i class="fa fa-plus-circle"></i></div>';
        $data = array("html"=>$html);
    break;


    default : $Error = "ERROR Action Not Found ! ";
}

$data["error"] = $Error;
echo json_encode($data);



function get_phones($id){
    $html = "<span>ტელეფონი</span>";
    global $db;
    $mysql = $db;
    $query = "SELECT `id`,`phone` from `phones` WHERE active = 1 AND `user_id`=" . $id;
    $res = $mysql->query($query);
    $i=0;
    while($result = $res->fetch_assoc()){
        $html.='<div class="phone-grid-in">
                    <input type="text" value="'.$result['phone'].'" readonly/>
                        <button class="delete" title="წაშლა" row_id = "'.$result['id'].'" >
                            <i class="fas fa-minus"></i>
                        </button> 
                </div>';
        $i++;
    }
    if($i<3){
        $html .= '<div class="phone-grid-in">
                    <input type="text" value="" maxlength="9"/>
                    <button class="add" title="დამატება">
                        <i class="fas fa-plus"></i>
                    </button> 
                </div>';
    }

    return $html;
  }

?>