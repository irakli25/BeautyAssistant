<?php
// Start the session
session_start();
?>
<?php require_once("classes/class.page.php");?>
<?php require_once("functions.php");

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" type="icon/png" href="media/icons/logo.ico" />
    <meta name="description" content="Your Beauty Assistant">
    <meta name="keywords" content="HTML,CSS,XML,JavaScript">
    <meta name="author" content="Irakli Tabukashvili">
    <meta name="theme-color" content="var(--main-color)" />
    <?php echo get_css();?>
    <?php echo get_js();?>
    <title>Beauty Assistant</title>
</head>
<body>
    <?php

    // menu
    require_once("front/menu.php");

    if(isset($_REQUEST["route"])){
        $route=$_REQUEST["route"];
    } else {
        $route=1;
    }


    // content
    $page=new Page($route);
    $page->get_page();

    // footer
    require_once("front/footer.php");
    ?>
</body>
</html>