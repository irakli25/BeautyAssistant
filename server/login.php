<?php

require_once("../classes/class.db.php");
session_start();

$db = new DB();
$data = array();
$error = '';
$user_pass = '';
$email =htmlentities($_REQUEST['email']);
$password = md5(htmlentities($_REQUEST['pass']));

$query = "SELECT `id`, `password`, `name` FROM `users` WHERE `email` = '$email' ";

$res = $db -> query($query);

$user = $res ->fetch_assoc();

if($user['password'] == $password){
    $data['result'] = true;
    $_SESSION['USER'] = $user['id'];
    $_SESSION['USER_NAME'] = $user['name'];
}
else $error = "ელფოსტა ან პაროლი არასწორია";

$data['Error'] = $error;
echo json_encode($data);
?>