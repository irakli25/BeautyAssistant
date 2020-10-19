<?php
ini_set('display_errors', 1);
require_once("../classes/class.db.php");

$db = new DB();

$email = $_REQUEST['email'];

$query = "UPDATE users
                    SET `authentication` = '1'
                        WHERE `email` = '$email' ";
$db->query($query);  


$query = "SELECT `uid` FROM users
                        WHERE `email` = '$email' ";
$res = $db->query($query);  
$arr = $res->fetch_assoc();

header("Location: http://".$_SERVER[HTTP_HOST]."/?route=7&uid=".$arr["uid"]);
exit();

?>