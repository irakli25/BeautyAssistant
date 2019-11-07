<?php
require_once "../../classes/class.client.php";
require_once "../../classes/class.staff.php";
require_once "../../classes/class.db.php";
session_start();

$db = new DB();
$uid = $_REQUEST['uid'];

if($uid == "client"){

    $profile = new Client($db);

  echo  $profile->getPage();

}
else{
    $profile = new Staff($db,$uid);

   echo $profile->getPage();
}

?>