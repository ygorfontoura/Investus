<?php

    require("model/users.php");
    // require("assets/php/functions.php");
    $users = new Users();
    $account = new Users();
    $actions = ["analyses", "investments", "settings", "support", "transferlog", "userprofile"];
    $details = ["update", "addCC", "addBank"];
    

    if(isset($_SESSION['user_id']) && isset($_SESSION['api_key'])) {
        require("view/dashboard.php");
        if(isset($_POST['update']) && $action == "userprofile"){         
            $success = $users->update($_POST);
        }
        elseif(isset($_POST['update']) && $action == "settings"){         
            $success = $account->update($_POST);
        }
        elseif(isset($_POST['addCC']) || isset($_POST['addBank'])){
            $users->addFunds($_SESSION['user_id'], $_POST);
        }
    } else {header("Location:".ROOT."auth/login");}


?>