<?php
    require_once("stocks.php");
    print_r($_POST);
    if(isset($_POST['amount'])){ 
        $buyStock = new Stock();
        $buyStock->amount = $_POST['amount'];
        print_r($buyStock);
    }
?>