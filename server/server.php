<?php

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

require_once("../classes/class.db.php");
session_start();
$action = $_REQUEST['act'];
$Error  = "";

$data = array();
$db = new DB();

switch ($action){

    case "get_list_staff" :
        $html = "";
        $query = "SELECT  `users`.`id`,
                `users`.`name`, 
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
            <div class="profile shadow" link = "?route=7&uid='.$arr['uid'].'" user_id = "'.$arr['id'].'">
					<div class="profile_image" style="background-image:url(\'server/uploads/'.$arr['img'].'\')"></div>
					<div class="profile_text">
                        <h3>'.$arr['name'].' '.$arr['surname'].'</h3>
                        <br>
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

    case "save_order":
        $user_id = $_SESSION['USER'];
        $assistant = $_REQUEST['assistant'];
        $products = $_REQUEST['products'];
        $district = $_REQUEST['district'];
        $street = $_REQUEST['street'];
        $address = $_REQUEST['address'];

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

                $email = "<p> ".get_username($user_id)." თქვენ გაქვთ ახალი შეკვეთა</p>
                            <p> ასისტენტი : ".get_username($assistant)."
                            <p>მომსახურება : ".get_products($order_id)."</p>
                            <p>ფასი : ".$price."</p>
                            <p>მისამართი : ".get_address($order_id)." </p>

                ";

                
                $res = $db->query("SELECT `uid` FROM users WHERE id = $assistant");
                $arr = $res->fetch_assoc();
                $link = "<p>შეკვეთის ლინკი : http://localhost:81/?route=8&uid=".$arr['uid']."&order_id=".$order_id."</p>";
                $data = array("id" => $order_id,"email" => $email, "link" => $link);
        }
        else $Error = "თქვენ არ ხართ ავტორიზებული, გაიარეთ ავტორიზაცია";
        

    break;

    case "select" :
        $table = $_REQUEST['table_name'];
        $name  = $_REQUEST['list'];
        $parent_id = $_REQUEST['parent_id'];
        $parent_name = $_REQUEST['parent_name'];
        $arr = get_select ($table, $name,$parent_id, $parent_name);
        $arr_string = get_select_active($table, $name);
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
    $query = "SELECT  GROUP_CONCAT(experience.`name`) AS `products`
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

function get_select ($table, $name,$parent_id, $parent_name){
    $db = new DB();
    $user_id = $_SESSION['USER'];
    $array = array();
    $query = "SELECT  `id` , `$table`.`name`
    FROM `$table` 
    ";
    if($parent_id !=0 && $parent_name != ""){
        $query .= "WHERE `$parent_name` = $parent_id";
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
    $user_id = $_SESSION['USER'];
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

WHERE  users.active = 1 AND users.name is not null AND user_experience.experience_id in ($expe) AND user_district.district_id = $dist
group by users.id
having count(distinct  user_experience.experience_id) = $size";


    $res = $db->query($query);
    while ($r = $res->fetch_assoc()){
        array_push($array,array("name"=>$r['name'],"id"=>$r['id'], "img"=> $r['img']));
    }

    return $array;
}

?>