<?php
    if(isset($_SESSION['user_id']) && isset($_SESSION['api_key'])) {
        require("view/dashboard.php");
    } else {header("Location:".ROOT."auth/login");}

    $actions = ["analyses", "investments", "settings", "support", "transferlog", "userprofile"];
    
    if(isset($action) && in_array($action, $actions)){
        return $action;
    } else {$action = "analyses";return $action;}
?>