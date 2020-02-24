<div class="row">
    <div class="col-sm shadow p-3 mb-5 bg-white rounded text-dark">
    <p class="h4">My stocks</p>
    <table class="table">
        <tr class="font-weight-bold">
            <th scope="col">NAME</th>
            <th scope="col">SYMBOL</th>
            <th scope="col">QUANTITY</th>
            <th scope="col">TOTAL INCOME</th>
        </tr>
        <?php 
            $allStocks = $stock->getStocks($_SESSION['user_id']);
            foreach($allStocks as $stock){
                $stockInfo = $stock->getStock($stock->symbol);
                $stockCurrentValue = ($stockInfo->latestPrice / $currencies['USD']) * $stock->amount;
                $stockBuyValue = $stock->buy_price * $stock->amount;
                $stockIncome = $stockCurrentValue - $stockBuyValue;
                $income = convertCurrency($currencies, $user_account->currency, $stockIncome);
        ?>
        <tr>
            <td scope="row"><a href="<?=ROOT?>dashboard/stock/<?=$stock->symbol?>"><?= $stockInfo->companyName;?></a></td>
            <td scope="row"><?= $stockInfo->symbol;?></td>
            <td scope="row"><?= $stock->amount;?></td>
            <td scope="row" class="<?= ($income >= 0) ?  "positive" :  "negative"?>"><?= number_format($income, 2, ".",".");?> <?=(!$user_account->currency) ? "€" : CURRENCYSYMBOL[$user_account->currency]?></td>
        </tr>
        <?php } ?>
    </table>
    </div>
</div>
<div class="row ">
    <div class="col-sm shadow p-3 mb-5 bg-white rounded text-dark">
        <p class="h4">My stocks detailed</p>
        <table class="table">
            <tr class="font-weight-bold">
                <th scope="col">NAME</th>
                <th scope="col">SYMBOL</th>
                <th scope="col">LAST</th>
                <th scope="col">%</th>
                <th scope="col">BUY PRICE</th>
                <th scope="col">DIFFERENCE</th>
                <th scope="col">INCOME PER ACTION</th>
                <th scope="col">QUANTITY</th>
                <th scope="col">BOUGHT AT</th>
            </tr>
            <?php 
                $userStocks = $stock->getStocks($_SESSION['user_id']);
                foreach($userStocks as $userStock) {
                    $stockInfo = $stock->getStock($userStock->symbol);
                    $lastPrice = $stockInfo->latestPrice / $currencies['USD'];
                    $convertedLastPrice = convertCurrency($currencies, $user_account->currency, $lastPrice);
                    $buyPrice = $userStock->buy_price;
                    $convertedBuyPrice = convertCurrency($currencies, $user_account->currency, $buyPrice);
                    $income = $convertedLastPrice - $convertedBuyPrice;
                    ?>
            <tr>
                <td scope="row"><a href="<?=ROOT?>dashboard/stock/<?=$userStock->symbol?>"><?= $stockInfo->companyName;?></a></td>
                <td scope="row"><?= $userStock->symbol;?></td>
                <td scope="row"><?= number_format($convertedLastPrice, 2, ".",","); ?> <?php echo (!$user_account->currency) ? "€" : CURRENCYSYMBOL[$user_account->currency];?></td>
                <td scope="row" class="<?= ($stockInfo->changePercent*100 >= 0) ?  "positive" :  "negative"?>"><?= round($stockInfo->changePercent*100, 2, PHP_ROUND_HALF_EVEN);?>%</td>
                <td scope="row"><?= number_format($convertedBuyPrice, 2, ".",".");?> <?php echo (!$user_account->currency) ? "€" : CURRENCYSYMBOL[$user_account->currency];?></td>
                <td scope="row" class="<?= ($stockInfo->changePercent*100 >= 0) ?  "positive" :  "negative"?>"><?= round($income/100, 2, PHP_ROUND_HALF_EVEN)?>%</td>
                <td scope="row" class="<?=($income <= 0) ? "negative" : "positive";?>"><?= number_format($income, 2, ".",".")?> <?php echo (!$user_account->currency) ? "€" : CURRENCYSYMBOL[$user_account->currency];?></td>
                <td scope="row"><?= $userStock->amount;?></td>
                <td scope="row"><?= $userStock->boughtAt;?></td>
            </tr>
            <?php } ?>
        </table>
    </div>
</div>
