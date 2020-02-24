<?php
    require("model/users.php");
    $user = new User();
    $actions = ["login", "register", "logout", "forgot"];
    
    if(isset($action) && in_array($action, $actions)) {
        if(isset($_SESSION['user_id']) && ($action === "login" || $action === "register")){
            header("Location:".ROOT);
        }
        if(isset($_POST['login']) || $action === "logout") {
            $success = $user->{$action}($_POST);

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
        if($action == "forgot" && isset($_POST['forgot'])){
            $result = $user->genForgetKey($_POST);
            if($result) header("Location:".ROOT);
        }
        if($action == "forgot" && isset($_POST['newPwd'])){
            $result = $user->updatePassword($_POST);
            $decode = json_decode($result, true);
            if($decode['success']) {
                header("Location:".ROOT."auth/login");
            } else {
                header("Location:".ROOT."auth/forgot");
            }
        }
    } else {
        header("Location:".ROOT);
    }
    include("view/".$action.".php");
?>