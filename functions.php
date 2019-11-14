<?php
$rand=rand();


function get_css(){
    global $rand;
    $css="  <link rel='stylesheet' href='css/modern-normalize.css'/>
            <link rel='stylesheet' href='css/style.css?v=".$rand."'>
            <link rel='stylesheet' href='css/menu.css?v=".$rand."'>
            <link rel='stylesheet' href='front/home/home.css?v=".$rand."'>
            <link rel='stylesheet' href='front/login/login.css?v=".$rand."'>
            <link rel='stylesheet' href='front/profile/profile.css?v=".$rand."'>
            
            <!-- Kendo UI -->
            <link rel='stylesheet' href='js/kendo/styles/kendo.common-material.min.css'/>
            <link rel='stylesheet' href='js/kendo/styles/kendo.custom.css'/>
            <link rel='stylesheet' href='js/kendo/styles/kendo.default-v2.min.css'/>

            ";

    return $css;
}
function get_js(){
    global $rand;
    $js="   <script src='js/jquery-3.3.1.min.js'></script>
            <script src='js/jquery-ui.min.js'></script>
            <script src='js/scripts.js?v=".$rand."'></script>
            <script src='front/home/home.js?v=".$rand."'></script>
            <script src='front/profile/profile.js?v=".$rand."'></script>
            <script src='js/fa.js' crossorigin='anonymous'></script>

            <!-- Kendo UI -->
            <script src='js/kendo/js/kendo.all.min.js'></script>
            <script src='js/kendo/js/cultures/kendo.culture.ka-GE.min.js'></script>

           ";
    return $js;
}


?>
