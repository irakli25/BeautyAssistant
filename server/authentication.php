<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once("../classes/class.db.php");

$db = new DB();

$email = $_REQUEST['email'];

$query = "UPDATE users
                    SET `authentication` = '1'
                        WHERE `email` = '$email' ";
$db->query($query);  

header("Location: https://beautyassistant.herokuapp.com");


?>