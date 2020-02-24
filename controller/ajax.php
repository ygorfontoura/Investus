<?php

    require_once("model/stocks.php");
    require_once("model/accounts.php");
    $stock = new Stock();
    $account = new Account();

    if(isset($_SESSION['user_id']) && isset($_SESSION['api_key'])){
        if(isset($_POST['buyStock'])){
            $stock->buyStock($_SESSION['user_id'], $_POST);
        }
        elseif(isset($_POST['sellStock'])){
            $stock->sellStock($_SESSION['user_id'], $_POST);
        }
        elseif(isset($_POST['fetchStocks'])){
            $result = $stock->fetchStocks();
            echo $result['stocks'];
        }
        elseif(isset($_POST['getHistory'])){
            $stock->getStockHistory($_POST['symbol']);
        }
        elseif(isset($_POST['withdraw'])){
            $account->withdraw($_SESSION['user_id'], $_POST);
        }
    }
?>
