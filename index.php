<?php require_once("classes/class.page.php");?>
<?php require_once("functions.php");?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" type="icon/png" href="media/icons/logo.png" />
    <meta name="description" content="Beauty and Fashion">
    <meta name="keywords" content="HTML,CSS,XML,JavaScript">
    <meta name="author" content="Irakli Tabukashvili">
    <?php echo get_css();?>
    <?php echo get_js();?>
    <title>Beauty Assistant</title>
</head>
<body>
    <?php

    if(isset($_REQUEST["pg"])){
        $pg=$_REQUEST["pg"];
    } else {
        $pg=1;
    }
    // menu
    require_once("front/menu.php");

    // content
    $page=new Page($pg);
    $page->get_page();

    // footer
    require_once("front/footer.php");
    ?>
</body>
</html>