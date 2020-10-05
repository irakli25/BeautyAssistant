<?php
ini_set('display_errors', 1);
require_once("../classes/class.db.php");

$db = new DB();

$email = $_REQUEST['email'];

$query = "UPDATE users
                    SET `authentication` = '1'
                        WHERE `email` = '$email' ";
$db->query($query);  

header("Location: http://".$_SERVER[HTTP_HOST]."/?route=1");
exit();

?>