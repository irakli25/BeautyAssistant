<?php

require_once "../../classes/class.db.php";
session_start();
$action = $_REQUEST['act'];
$Error  = "";
$data = array();
$db = new DB();

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
        $done = false;
        $ids = $_REQUEST['ids'];
        $user_id = $_SESSION['USER'];
        $query = "DELETE FROM `user_district` WHERE `user_id` = '$user_id'";
        $db->query($query);
        foreach($ids as $id){
            $query = "INSERT INTO `user_district` SET `district_id` = '$id', `user_id` = '$user_id', `datetime` = NOW()";
            $done = $db->query($query);
        }
        if(! $done && $ids != NULL){
            $Error =" დაუდგენელი შეცდომა !";
        }
    break;
    case "update_district_user" :
        $done = false;
        $id = $_REQUEST['ids'];
        $user_id = $_SESSION['USER'];
        $query = "DELETE FROM `user_district` WHERE `user_id` = '$user_id'";
        $db->query($query);

            $query = "INSERT INTO `user_district` SET `district_id` = '$id', `user_id` = '$user_id', `datetime` = NOW()";
            $done = $db->query($query);

        if(! $done){
            $Error =" დაუდგენელი შეცდომა !";
        }
    break;
    case "save_finance":
        $id = $_REQUEST['id'];
        $arr = $_REQUEST['arr'];
        foreach($arr as $k => $v ){
            $query = "SELECT * FROM `finance` WHERE `experience_id` = $k AND `user_id` = $id ";
            $num = $db->numRows($query);
            if($num == 0){
                $query = "INSERT INTO `finance` SET `datetime` = now(), `user_id` = '$id', `experience_id` = '$k', `price` = '$v'";
                $db->query($query);
            }
            else{
                $query = "UPDATE `finance` SET `datetime` = now(), `price` = '$v' WHERE `user_id` = '$id' AND `experience_id` = '$k'";
                $db->query($query);
            }
        }
    break;

    case "get_price":
        $profile = $_REQUEST['profile'];
        $experience = $_REQUEST['exp'];
        if($experience != ''){

        if (is_array($experience)){
            $exp = implode(",", $experience);
        }
        else{
            $exp = $experience;
        }
        $query = "SELECT SUM(price) AS `price`
                    FROM finance
                    WHERE user_id = '$profile' AND experience_id in ($exp)";

        $req = $db->query($query);
        $res = $req->fetch_assoc();

        $price = $res['price'] == "" ? 0.00 : $res['price'];

        $data = array("price" => $price);
        }
        else{
            $data = array("price" => 0);
        }

    break;
    case "get_uid":
        $id = $_REQUEST['id'];
        if($id > 0){
            $query = "SELECT `uid` FROM users WHERE id = $id";
            $req = $db->query($query);
            $res = $req->fetch_assoc();
            $link = "?route=7&uid=".$res['uid'];
            $data = array("link" => $link);
        }
        else{
            $Error = "შეცდომა ! არასწორი ასისტენტი";
        }
        
    break;
    case "update" :
        $done = false;
        $id = $_REQUEST['id'];
        $table = $_REQUEST['table'];
        $user_id = $_SESSION['USER'];
        $query = "DELETE FROM `user_$table` WHERE `user_id` = '$user_id'";
        $db->query($query);

            $query = "INSERT INTO `user_$table` SET ".$table."_id = '$id', `user_id` = '$user_id', `datetime` = NOW()";
            $done = $db->query($query);

        if(! $done){
            $Error =" დაუდგენელი შეცდომა !";
        }
    break;

    case "update_experience" :
        $done = false;
        $ids = $_REQUEST['ids'];
        $user_id = $_SESSION['USER'];
        $query = "DELETE FROM `user_experience` WHERE `user_id` = '$user_id'";
        $db->query($query);
        foreach($ids as $id){
            $query = "INSERT INTO `user_experience` SET `experience_id` = '$id', `user_id` = '$user_id', `datetime` = NOW()";
            $done = $db->query($query);
        }
        if(! $done && $ids != NULL){
            $Error =" დაუდგენელი შეცდომა !";
        }
    break;
    case "get_history_window":
        $id = $_REQUEST['id'];
        $query = "SELECT o.id,o.datetime, CONCAT(clients.`name`,' ',clients.surname)  AS client, GROUP_CONCAT(experience.`name`) AS `exp`, o.price,  CONCAT(district.`name`, ' ', street.`name`, ' ', o.local_address) AS street

        FROM orders o
        JOIN users AS clients ON o.client_id = clients.id
        JOIN products ON products.order_id = o.id
        JOIN experience ON experience.id = products.experience_id
        JOIN district ON district.id = o.district_id
		JOIN  street ON o.street_id = street.id
        WHERE o.id = $id
        group by o.id
        ";
        $result = $db->query($query);
        $res = $result->fetch_assoc();
        $data = array("datetime" => $res[datetime], "client" => $res[client],"exp" => $res[exp], "price" => $res[price], "street" => $res[street]);
        

    break;
    case "get_history_window_client":
        $id = $_REQUEST['id'];
        $query = "SELECT o.id,o.datetime, CONCAT(staff.`name`,' ',staff.surname)  AS client, GROUP_CONCAT(experience.`name`) AS `exp`, o.price,  CONCAT(district.`name`, ' ', street.`name`, ' ', o.local_address) AS street

        FROM orders o
        JOIN users AS staff ON o.staff_id = staff.id
        JOIN products ON products.order_id = o.id
        JOIN experience ON experience.id = products.experience_id
        JOIN district ON district.id = o.district_id
		JOIN  street ON o.street_id = street.id
        WHERE o.id = $id
        group by o.id
        ";
        $result = $db->query($query);
        $res = $result->fetch_assoc();
        $data = array("datetime" => $res[datetime], "client" => $res[client],"exp" => $res[exp], "price" => $res[price], "street" => $res[street]);
        

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

    case "save_user_pic" :
        $id = $_REQUEST['id'];
        $user_id = $_SESSION['USER'];
        $query = "UPDATE `users` SET `img` = '$id' WHERE id = '$user_id' ";
        $db->query($query);

    break;
    case "get_images":

        $query = "SELECT  img, `rand_name`
                    FROM `users`
                    JOIN `file` ON `users`.img = `file`.id";
                    $res = $db->query($query);
        while($result = $res->fetch_assoc()){
            $data[$result['img']] = $result['rand_name'];
        }

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