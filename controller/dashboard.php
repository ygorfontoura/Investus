<?php

    require("model/users.php");
    require_once("model/accounts.php");
    // require("assets/php/functions.php");
    $user = new Users();
    $account = $user->account = new Accounts();
    $actions = ["analyses", "investments", "settings", "support", "transferlog", "userprofile"];
    $details = ["update", "addCC", "addBank"];
    

    if(isset($_SESSION['user_id']) && isset($_SESSION['api_key'])) {
        require("view/dashboard.php");
        if(isset($_POST['update']) && $action == "userprofile"){         
            $success = $user->update($_POST);
        }
        elseif($action == "settings" && isset($_POST['update'])){ 
            $account = $account->getAccount($_SESSION['user_id']);
            $success = $account->update($_SESSION['user_id'], $_POST);
        }
        elseif(isset($_POST['addCC']) || isset($_POST['addBank'])){
            if(!empty($_POST['typeBank']) && isset($_POST['addBank'])){
                $account->addFunds($_SESSION['user_id'], $_POST);
            }
            if(!empty($_POST['typeCCard']) && isset($_POST['addCC'])){
                $account->addFunds($_SESSION['user_id'], $_POST);
            }
        }
    } else {header("Location:".ROOT."auth/login");}


?>