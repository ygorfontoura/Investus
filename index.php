<?php
    session_start();
    
    $controllers = ["auth", "home", "news", "aboutus", "api"];
    $controller = "home";
    define("ROOT", "/Investus/");

    $url_parts = explode("/", $_SERVER["REQUEST_URI"]);
    if(isset($url_parts[2]) && in_array($url_parts[2], $controllers)){
        $controller = $url_parts[2];
        if(isset($url_parts[3])){
            $action = $url_parts[3];
        }
        if(isset($url_parts[4])){
            $detail = $url_parts[4];
        }
    }
    require("controller/" .$controller. ".php");
    
?>
