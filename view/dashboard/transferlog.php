<?php $transactionLog = new Transaction;?>
<div class="row">
    <div class="col-lg-12 shadow p-3 mb-5 bg-white rounded text-dark">
        <p class="h4">Stocks log <button type="button" id="stockBtn" data-toggle="collapse" data-target="#stocksTable" class="invisBtn">-</button></p>
        <table class="table collapse show" id="stocksTable">
            <tr class="font-weight-bold">
                <th scope="col">NAME</th>
                <th scope="col">SYMBOL</th>
                <th scope="col">BUY PRICE</th>
                <th scope="col">TOTAL PRICE</th>
                <th scope="col">QUANTITY</th>
                <th scope="col">BOUGHT AT</th>
            </tr>
            <?php 
                $userStocksLogs = $transactionLog->getLogs($_SESSION['user_id'], "Stock Purchase");
                foreach($userStocksLogs as $userStock) {
                    $stockInfo = $stock->getStock($userStock->symbol);
                    ?>
            <tr>
                <td scope="row"><a href="<?=ROOT?>dashboard/investments"><?= $stockInfo->companyName;?></a></td>
                <td scope="row"><?= $stockInfo->symbol;?></td>
                <td scope="row"><?php
                    $buy_price = number_format(convertCurrency($currencies, $user_account->currency, $userStock->buy_price), 2, ".",",");
                    echo $buy_price;
                ?>
                    <span>
                    <?php echo (!$user_account->currency) ? "€" : CURRENCYSYMBOL[$user_account->currency];?>
                    </span>
                </td>
                <td scope="row"><?php
                    $total = number_format(convertCurrency($currencies, $user_account->currency, $userStock->buy_price*$userStock->amount), 2, ".",",");
                    echo $total;
                ?>
                    <span>
                    <?php echo (!$user_account->currency) ? "€" : CURRENCYSYMBOL[$user_account->currency];?>
                    </span>
                </td>
                <td scope="row"><?= $userStock->amount;?></td>
                <td scope="row"><?= $userStock->createdAt;?></td>
            </tr>
            <?php } ?>
        </table>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 shadow p-3 mb-5 bg-white rounded text-dark">
        <p class="h4">Funds log <button type="button" id="logBtn" data-toggle="collapse" data-target="#transferTable" class="invisBtn">-</button></p>
        <table class="table collapse show" id="transferTable">
            <tr>
                <th scope="col">Value</th>
                <th scope="col">Action</th>
                <th scope="col">Date</th>
            </tr>
                <?php 
                    $logs = $transactionLog->getLogs($_SESSION['user_id'], "Funds added", "Withdraw");
                    foreach($logs as $log){
                ?>
            <tr>
                <td scope="row"><?=number_format(convertCurrency($currencies, $user_account->currency, $log->value), 2, ".",",");?>
                <span>
                <?php echo (!$user_account->currency) ? "€" : CURRENCYSYMBOL[$user_account->currency];?>
                </span>
                </td>
                <td scope="row"><?=$log->action?></td>
                <td scope="row"><?=$log->createdAt?></td>
            </tr>
                <?php  } ?>
        </table>
    </div>
</div>
