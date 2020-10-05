<?php

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

require_once("../classes/class.db.php");
session_start();
$Error  = "";
if(isset($_REQUEST['act']))
    $action = $_REQUEST['act'];
    else {
        $action = "";
    }


$data = array();
$db = new DB();

switch ($action){
    case "online":
        $status = isset($_SESSION['USER']) ? true : false;
        $data = array("status" => $status);
    break;
    case "get_list_staff" :
        $html = "";
        $query = "SELECT  `users`.`id`,
                `users`.`name`, 
                `users`.`surname`,  
                `users`.`about` ,
                `users`.`uid`,
                `users`.rating,
                `file`.`rand_name` AS `img`
                from users
                LEFT JOIN  file ON file.id = `users`.img
                WHERE `users`.`user_type_id` = 1 AND `status` = 1 AND active = 1";
        $res = $db->query($query);
        while($arr = $res->fetch_assoc()){
            $html .= '
            <div class="profile shadow" link = "?route=7&uid='.$arr['uid'].'" user_id = "'.$arr['id'].'">
					<div class="profile_image" style="background-image:url(\'server/uploads/'.$arr['img'].'\')"></div>
					<div class="profile_text">
                        <h3>'.$arr['name'].' '.$arr['surname'].'</h3>
                        <br>
						<p>'.$arr['about'].'</p>
                    </div>
                    <div class="rate">';
                    if ($arr['rating'] != 0){
                        for($i = 5; $i > 0; $i--){
                            $html .='<input type="radio"  value="'.$i.'" '.($arr['rating'] >= $i ? "checked" : "").' disabled/>
                            <label  title="'.$i.'"></label>';
                        }

                    }
            $html .= ' </div>
			</div>
            ';
        }
        $data = array("html"=>$html);

    break;

    case "save_rate":

        $id = $_REQUEST['id'];
        $rate = $_REQUEST['count'];
        $query = "UPDATE `orders` SET `rate` = '$rate' WHERE id = '$id'";
        
        $query = "SELECT  ROUND(AVG(rate)) AS `avg`,  count(id) AS `count` FROM orders WHERE  staff_id = (SELECT staff_id FROM orders WHERE id = '$id');"; // round 2.5
        $res = $db->query($query);
        $arr = $res->fetch_assoc();
        if ($arr['count'] > 10){ // after this count order
            $query = "UPDATE `users` SET `rating` = '$arr[avg]' WHERE id = (SELECT staff_id FROM orders WHERE id = '$id'); ";
            $res = $db->query($query);
        }

        $data = array("status"=>$res);
    break;

    case "get_mail":
       
        if(isset($_SESSION['USER'])){
            $id = $_SESSION['USER'];
            $query = "SELECT `email` FROM `users` WHERE `id` = '$id' ";
            $res = $db->query($query);
            $arr = $res->fetch_assoc();
            $data = array("email"=>$arr['email']);
        }
        $data = array("email"=>"Null");
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

    case "save_order":
        $user_id = $_SESSION['USER'];
        $assistant = $_REQUEST['assistant'];
        $products = $_REQUEST['products'];
        $district = $_REQUEST['district'];
        $street = $_REQUEST['street'];
        $address = $_REQUEST['address'];
        $order_time = $_REQUEST['order_time'];

        if($user_id != ''){

                if (is_array($products)){
                    $expe = implode(",",$products);
                }
                else{
                    $expe = $products;

                }

                $query = "SELECT SUM(price) AS `price` FROM finance WHERE user_id = $assistant AND experience_id in ($expe)";
                $res = $db->query($query);
                $p = $res->fetch_assoc();
                $price = $p['price'];
                

                $query = "INSERT INTO `orders`
                                SET `datetime` = NOW(),
                                    `order_time` = '$order_time',
                                    `staff_id` = $assistant,
                                    `client_id`= $user_id,
                                    `district_id` = $district,
                                    `street_id` = $street,
                                    `local_address` = '$address',
                                    `price`         = $price,
                                    `status`        = 1
                                ";

                $db->query($query);

                $order_id = $db->lastId();

                for($i=0; $i<sizeof($products); $i++){
                    $query = "INSERT INTO `products`
                                    SET experience_id = '$products[$i]',
                                        `order_id` = '$order_id' ";
                                        $db->query($query);
                }

                $query = "INSERT INTO `order_status`
                                    SET `user_id` = '$assistant',
                                        `order_id` = '$order_id',
                                        `status` = 0 ";
                                        $db->query($query);

                $query = "SELECT 
                (SELECT  users.email from users WHERE id = $user_id) AS `user`,
                (SELECT  users.email from users WHERE id = $assistant) AS `assistant`";

                $res = $db->query($query);
                $emails = $res->fetch_assoc();


                $user_email_text = "<p> ".get_username($user_id)." თქვენ გაქვთ ახალი შეკვეთა</p>
                            <p> ასისტენტი : ".get_username($assistant)."
                            <p>მომსახურება : ".get_products($order_id)."</p>
                            <p>ფასი : ".$price."</p>
                            <p>მისამართი : ".get_address($order_id)." </p>
                            <p>მოსვლის დრო : ".$order_time." </p>

                ";

                $assistan_email_text = "<p> ".get_username($assistant)." თქვენ გაქვთ ახალი შეკვეთა</p>
                <p> კლიენტი : ".get_username($user_id)."
                <p>მომსახურება : ".get_products($order_id)."</p>
                <p>ფასი : ".$price."</p>
                <p>მისამართი : ".get_address($order_id)." </p>
                <p>მისვლის დრო : ".$order_time." </p>
    ";

                
                $res = $db->query("SELECT `uid` FROM users WHERE id = $assistant");
                $arr = $res->fetch_assoc();
                $link = "<p><a href = 'http://localhost:81/?route=8&uid=".$arr['uid']."&order_id=".$order_id."'</a>მართე შეკვეთა</p>";
                $data = array("id" => $order_id,"user_email_text" => $user_email_text, "assistan_email_text" => $assistan_email_text ,"link" => $link, "user_email" => $emails["user"], "assistant_email" => $emails["assistant"]);
        }
        else $Error = "თქვენ არ ხართ ავტორიზებული, გაიარეთ ავტორიზაცია";
        

    break;

    case "select" :
        $table = $_REQUEST['table_name'];
        $name  = $_REQUEST['list'];
        $parent_id = $_REQUEST['parent_id'];
        $parent_name = $_REQUEST['parent_name'];
        $profile_id = $_REQUEST["profile"];
        $arr = get_select ($table, $name,$parent_id, $parent_name,$profile_id);
        if(isset($_SESSION['USER']))
            $arr_string = get_select_active($table, $name);
            else {
                $arr_string = "[]";
            }
        $data = array("arr" => $arr, "arr_string" => $arr_string);
    break;
    case "selectwp" :
        $table = $_REQUEST['table_name'];
        $name  = $_REQUEST['list'];
        $exp = $_REQUEST['exp'];
        $dist = $_REQUEST['dist'];
        $arr = get_selectwp ($table, $name, $exp, $dist);
        $data = array("arr" => $arr);
    break;
    case "get_status":
        $query = "SELECT `status` FROM `users` WHERE `id` = $_SESSION[USER]";
        $res = $db->query($query);
        $arr = $res->fetch_assoc();
        $status = $arr["status"] ? true : false;
        $text = $status ? "ჩართულია" : "გამორთულია";
        $data = array("status" => $status, "text" => $text);
    break;
    case "update_status":
        $status = $_REQUEST["status"];
        $query = "UPDATE `users` SET `status` = '$status' WHERE id = $_SESSION[USER]";
        $query_status = $db->query($query);
        $data = array("status" => $query_status);
    break;
    
    default : $Error = "უცნობი ქეისი";

}

$data["error"] = $Error;
echo json_encode($data);


function get_username($id){
    global $db;

    $query = "SELECT CONCAT(`name`, ' ', `surname`) AS `name` FROM `users` WHERE `id` = $id ";
    $res = $db->query($query);
    $arr = $res->fetch_assoc();
    return $arr['name'];
}

function get_products($id) {
    global $db;
    $query = "SELECT  GROUP_CONCAT(experience.`name` SEPARATOR ', ') AS `products`
    FROM products
    JOIN experience ON experience.id = products.experience_id
    WHERE order_id = $id
    GROUP BY order_id";
     $res = $db->query($query);
     $arr = $res->fetch_assoc();
     return $arr['products'];
}

function get_address($id) {
    global $db;
    $query = "SELECT  CONCAT(district.`name`,' ', street.`name`, ' ', o.local_address) `address`

    FROM orders o
    JOIN district ON o.district_id = district.id
    JOIN street ON o.street_id = street.id
    WHERE o.id = $id ";

$res = $db->query($query);
$arr = $res->fetch_assoc();
return $arr['address'];
}



function get_val($table_name,$get){
    $table = "user_".$table_name;
    $id = $table_name."_id";
    $db = new DB();
    $user_id = $_SESSION['USER'];
    $arr = array();
    $query = "SELECT `$id` AS `id` , `$table_name`.`name`
    FROM `$table` 
    JOIN `$table_name` ON `$table_name`.id = `$id`
    WHERE `user_id` = '$user_id'";
    $res = $db->query($query);
    while ($r = $res->fetch_assoc()){
        array_push($arr,array("name"=>$r['name'],"id"=>$r['id']));
    }

    if($get == "1" && sizeof($arr) > 0)
        return $arr;

    return 0;
}

function get_in($arr,$table_name){
    $db = new DB();
    $array = array();
    if($arr == "") $arr = 0;
    $query = "SELECT `id`, `name` FROM $table_name WHERE id in ($arr)";
    $res = $db->query($query);
    while ($r = $res->fetch_assoc()){
        array_push($array,array("name"=>$r['name'],"id"=>$r['id']));
    }

    return $array;

}

function get_select ($table, $name,$parent_id, $parent_name,$profile_id){
    $db = new DB();
    $array = array();
    $query = "SELECT  `id` , `$table`.`name`
    FROM `$table` 
    ";
    if($parent_id !=0 && $parent_name != ""){
        $query .= "WHERE `$parent_name` = $parent_id";
    }
    if($profile_id != "" && ($table == "experience" || $table == "district")){
        $query = "SELECT  `$table`.`id` , `$table`.`name`
                    FROM `user_$table`
                    JOIN `$table` On `$table`.id = user_$table.".$table."_id
                    WHERE `user_$table`.user_id = '$profile_id' ";
    }
    
    $res = $db->query($query);
    while ($r = $res->fetch_assoc()){
        array_push($array,array("name"=>$r['name'],"id"=>$r['id']));
    }
   
    return $array;
}

function get_select_active ($table, $name) {
    $db = new DB(); 
    $query = "SELECT  `$table`.`id` 
                    FROM `user_$table`
                    JOIN `$table` On `$table`.id = user_$table.".$table."_id
                    WHERE `user_$table`.user_id = '$_SESSION[USER]' ";
                    
    $res = $db->query($query); 
    $arr = "[";     
    while ($r = $res->fetch_assoc()){
        if($arr != "[")
            $arr .= ",";
        $arr .= $r['id'];
    }
    $arr .= "]";
   return $arr;
}

function get_selectwp ($table, $name, $exp, $dist){
    $db = new DB();
    $array = array();


if (is_array($exp)){
	$expe = implode(",",$exp);
	$size = sizeof($exp);
}
else{
	$expe = $exp;
	$arr = explode(",",$exp);
	$size = sizeof($arr);
}


$query = " SELECT users.id,  users.name, users.img 

FROM users 

JOIN user_experience ON user_experience.user_id = users.id
JOIN user_district ON user_district.user_id = users.id

WHERE  users.active = 1 AND users.status = 1 AND users.name is not null AND user_experience.experience_id in ('$expe') AND user_district.district_id = '$dist'
group by users.id
having count(distinct  user_experience.experience_id) = $size";


    $res = $db->query($query);
    while ($r = $res->fetch_assoc()){
        array_push($array,array("name"=>$r['name'],"id"=>$r['id'], "img"=> $r['img']));
    }

    return $array;
}

?>