<?php
    require("model/users.php");
    $users = new Users();
    $actions = ["login", "register", "logout"];
    
    if(isset($action) && in_array($action, $actions)) {
        if(isset($_SESSION['user_id']) && ($action === "login" || $action === "register")){
            header("Location:".ROOT);
        }
        if(isset($_POST['login']) || $action === "logout") {
            $success = $users->{$action}($_POST);

            if($success) {
                if($action === "register"){
                    header('Location:' .ROOT. "auth/login");
                } 
                elseif($action === "login") {
                    header("Location:".ROOT."dashboard/analyses");
                }
                else {
                    header("Location:" .ROOT);
                }
                exit;
            }
        }
    }
    include("view/".$action.".php");
?>