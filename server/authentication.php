<?php

require_once("../classes/class.db.php");

$email = $_REQUEST['email'];

$query = "UPDATE users
                    SET `authentication` = '1',
                        `email` = '$email' ";
$db->query($query);  


?>