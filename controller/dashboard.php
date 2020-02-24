<?php

    require("model/users.php");
    require_once("model/accounts.php");
    require_once("model/stocks.php");
    $user = new User();
    $stock = new Stock();
    $account = $user->account = new Account();
    $actions = ["analyses", "investments", "account", "support", "transferlog", "userprofile", "stock"];
    $details = ["update", "addCC", "addBank", "delete", "buyStock", "sellStock", "getHistory", "withdraw"];
    
    
    if(isset($_SESSION['user_id']) && isset($_SESSION['api_key'])) {
        require("view/dashboard.php");
        
        if(isset($_POST['update']) && $action == "userprofile"){         
            $success = $user->update($_POST);
        }

        elseif(isset($_SESSION['user_id']) && isset($detail) && in_array($detail, STOCKARR)){ 
            $success = $stock->getStock($detail);
        }

        elseif($action == "account" && isset($_POST['update'])){ 
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

        elseif(isset($_POST['delete']) && $action == "account") {
            $account->removeData($_SESSION['user_id'], $_POST['delete']);
        }        
    } else {header("Location:".ROOT."auth/login");}


?>