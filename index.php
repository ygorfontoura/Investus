<?php
    session_start();
    include("assets/php/config.php");
    

    $controllers = ["auth", "home", "ajax", "dashboard"];
    $controller = "home";

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
    if($_SERVER['QUERY_STRING'] && $controller == "auth"){
        $action = strtok($action, "?");
        if($action == "forgot"){
            $key = explode("=", $_SERVER['QUERY_STRING']);
            if($key[0] != "forgot_key") header("Location:".ROOT);
            require("view/newpwd.php");
        }
    }
    require("controller/" .$controller. ".php");
    
?>
