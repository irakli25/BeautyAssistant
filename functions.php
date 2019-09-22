<?php
$rand=rand();


function get_css(){
    global $rand;
    $css="  <link rel='stylesheet' href='css/modern-normalize.css'/>
            <link rel='stylesheet' href='css/style.css?v=".$rand."'>
            <link rel='stylesheet' href='css/menu.css?v=".$rand."'>
            <link rel='stylesheet' href='front/home/home.css?v=".$rand."'>
            <link rel='stylesheet' href='front/login/login.css?v=".$rand."'>


            ";

    return $css;
}
function get_js(){
    global $rand;
    $js="   <script src='js/jquery-3.3.1.min.js'></script>
            <script src='js/jquery-ui.min.js'></script>
            <script src='js/scripts.js?v=".$rand."'></script>
            <script src='front/home/home.js?v=".$rand."'></script>
           ";
    return $js;
}


?>
