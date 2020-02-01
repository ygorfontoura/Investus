<div class="row ">
    <div class="col-md-12 shadow p-3 mb-5 bg-white rounded text-dark">
        <p class="h4">Stocks log</p>
        <table class="table">
            <tr class="font-weight-bold">
                <th scope="col">NAME</th>
                <th scope="col">SYMBOL</th>
                <th scope="col">BUY PRICE</th>
                <th scope="col">TOTAL PRICE</th>
                <th scope="col">QUANTITY</th>
                <th scope="col">BOUGHT AT</th>
            </tr>
            <?php 
                $userStocks = (new Stock)->getStocks($_SESSION['user_id']);
                foreach($userStocks as $userStock) {
                    ?>
            <tr>
                <td scope="row"><?= $userStock->companyName;?></td>
                <td scope="row"><?= $userStock->symbol;?></td>
                <td scope="row"><?= ($user_account->currency == 'EUR') ? number_format($userStock->buy_price / $currencies['USD'], 2, ".",",") : number_format($userStock->buy_price / $currencies['USD'] * $currencies[$user_account->currency], 2, ".",",");?>
                    <span>
                    <?php echo (!$user_account->currency) ? "€" : $currency_symbols[$user_account->currency];?>
                    </span>
                </td>
                <td scope="row"><?= number_format($userStock->buy_price / $currencies['USD'] * $userStock->amount, 2, ".",",");?>
                    <span>
                    <?php echo (!$user_account->currency) ? "€" : $currency_symbols[$user_account->currency];?>
                    </span>
                </td>
                <td scope="row"><?= $userStock->amount;?></td>
                <td scope="row"><?= $userStock->boughtAt;?></td>
            </tr>
            <?php } ?>
        </table>
    </div>
</div>
<div class="row">
    <div class="col-md-12 shadow p-3 mb-5 bg-white rounded text-dark">
        <p class="h4">Funds log</p>
        <table class="table">
            <tr>
                <th scope="col">Value</th>
                <th scope="col">Action</th>
                <th scope="col">Date</th>
            </tr>
                <?php 
                    $logs = (new Transaction)->getLogs($_SESSION['user_id']);
                    foreach($logs as $log){
                ?>
            <tr>
                <td scope="row"><?php 
                                $value = ($user_account->currency != "EUR") ? number_format($log->value*$currencies[$user_account->currency], 2, ".",",") : number_format($log->value, 2, ".",","); echo $value;
                                ?>
                                <span>
                                <?php echo (!$user_account->currency) ? "€" : $currency_symbols[$user_account->currency];?>
                                </span>
                </td>
                <td scope="row"><?=$log->action?></td>
                <td scope="row"><?=$log->createdAt?></td>
            </tr>
                <?php  } ?>
        </table>
    </div>
</div>
