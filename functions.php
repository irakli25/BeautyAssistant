<?php
$rand=rand();

// $rand=1.0;


function get_css(){
    global $rand;
    $css="  
    
           


            <link rel='stylesheet' href='css/modern-normalize.css'/>
            <link rel='stylesheet' href='selectric/themes/p-th/selectric.css'>
            <link rel='stylesheet' href='css/menu.css?v=".$rand."'>
            <link rel='stylesheet' href='front/home/home.css?v=".$rand."'>
            <link rel='stylesheet' href='front/login/login.css?v=".$rand."'>
            <link rel='stylesheet' href='front/profile/profile.css?v=".$rand."'>
            <link rel='stylesheet' href='css/style.css?v=".$rand."'>

            
            ";

    return $css;
}
function get_js(){
    global $rand;
    $js="   <script src='js/jquery-3.4.1.min.js'></script>
            <script src='js/jquery-ui.min.js'></script>
            <script src='selectric/jquery.selectric.min.js'></script>
           
            <script src='js/scripts.js?v=".$rand."'></script>
            <script src='front/home/home.js?v=".$rand."'></script>
            <script src='front/profile/profile.js?v=".$rand."'></script>
            <script src='front/authentication/authentication.js?v=".$rand."'></script>
            <script src='fontawesome/js/all.js'></script>

        


           ";
    return $js;
}


?>
