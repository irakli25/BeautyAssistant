<?php 

require_once("../../classes/class.db.php");
session_start();
$action = $_REQUEST['act'];
$Error  = "";
$data = array();
$user_id = $_SESSION["USER"];
$data = array();
$db = new DB();

switch($action){
    case "get_buttons":
        $order_id = $_REQUEST['order_id'];
        $uid = $_REQUEST['uid'];
        $query = "SELECT $order_id in (SELECT o.id from users 
                    JOIN orders o ON o.staff_id = users.id
                    WHERE uid = '$uid' ) your_order";


        $res = $db->query($query);
        $arr = $res->fetch_assoc();

        $your_order = $arr['your_order'];

        $query = "SELECT uid FROM users WHERE id = '$user_id'";
        $res = $db->query($query);
        $arr = $res->fetch_assoc();


        if($your_order == "1" && $arr["uid"] == $uid){

            $hide = array();
            $query = "SELECT `status` FROM order_status WHERE order_id = $order_id LIMIT 1";
            $res = $db->query($query);
            $arr = $res->fetch_assoc();

            for($i = 0; $i< $arr['status']; $i++){
                $hide[$i] = "checked_button";
            }

            $html = '   <button class="'.$hide[0].'" status="1" >გავდივარ გამოძახებაზე</button>
                        <button class="'.$hide[1].'" status="2" >მივედი ადგილზე</button>
                        <button class="'.$hide[2].'" status="3" >დავასრულე</button>';

                        $data = array("html" => $html);
        }
        else {
            $Error = "გთხოვთ გაიაროთ ავტორიზაცია თქვენი იუზერით";
        }
    break;

    case "control_buttons" :
        $order_id = $_REQUEST['order_id'];
        $uid = $_REQUEST['uid'];
        $status = $_REQUEST['status'];

        $order_id = $_REQUEST['order_id'];
        $uid = $_REQUEST['uid'];
        $query = "SELECT $order_id in (SELECT o.id from users 
                    JOIN orders o ON o.staff_id = users.id
                    WHERE uid = '$uid' ) your_order";


        $res = $db->query($query);
        $arr = $res->fetch_assoc();

        $your_order = $arr['your_order'];

        if($your_order == "1" ){

                $query = "UPDATE `order_status`
                                            SET 
                                                `status` = $status
                                                WHERE `order_id` = $order_id ";
                                                $db->query($query);


                switch($status){
                    case "1":
                        $text = "ასისტენტი გავიდა მისამართზე";
                    break;
                    case "2":
                        $text = "ასისტენტი მივიდა ადგილზე";
                    break;
                    case "3":
                        $text = "ასისტენტმა დაასრულა მუშაობა";
                    break;
                }

                $query="SELECT email AS user_email
                FROM users 
                join orders ON orders.client_id = users.id
                WHERE orders.id = $order_id";

                $res = $db->query($query);
                $arr = $res->fetch_assoc();
                
                $data = array("text" =>$text , "id" => $order_id, "user_email" => $arr["user_email"]);
        }

    break;

    }

    $data['error'] = $Error;

    echo json_encode($data);