<?php $stock = $stock->getStock($detail);
    $userStocks = $stock->getUserStock($_SESSION['user_id'], $detail);
    $totalStocks = ($userStocks) ? $userStocks[0]['total'] : NULL;
?>
<div class="modal fade" id="modalPopUp" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content shadow p-3 mb-5 bg-white rounded justify-content-center">
            <div class="modal-header">
                <h5 class="modal-title text-dark" id="modalTitle">How many actions?</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="window.location.reload()">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-dark" id="modalMsg">
                <input type="number" id="stockQuantity" min="1" value="1">
                <button type="button" id="buyStock" name="buyStock">Buy!</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modalSellPopUp" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content shadow p-3 mb-5 bg-white rounded justify-content-center">
            <div class="modal-header">
                <h5 class="modal-title text-dark" id="sellModalTitle">How many actions?</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="window.location.reload()">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-dark" id="modalSellMsg">
                <input type="number" id="sellStockQuantity" min="1" max="<?=$totalStocks?>">
                <button type="button" id="sellStock" name="sellStock">Sell!</button>
            </div>
        </div>
    </div>
</div>
<div class="row userpanel p-3 text-dark shadow p-3 mb-5 bg-white rounded justify-content-center">
    <div class="col-lg-5">
        <p class="h4">Information</p>
        <div class="text-left">
            <p class="h5"><?=$stock->companyName?></p>
            <?php 
                $close = usdToEur($currencies, $stock->previousClose);
                $actual = usdToEur($currencies, $stock->latestPrice);
                $print = ($user_account->currency == 'EUR') ? number_format($actual - $close, 2) : 
                number_format(($actual - $close) * $currencies[$user_account->currency], 2, ".",",") ?>

            <p><?=$stock->primaryExchange?> : <?=$stock->symbol?> <span class="<?= ($print >= 0) ? "positive" : "negative"; ?>"><?=$print;?><?=(!$user_account->currency) ? "€" : CURRENCYSYMBOL[$user_account->currency];?></span>

            (<span class="<?= ($print >= 0) ? "positive" : "negative";?>"><?=number_format($stock->changePercent * 100, 2)?>%</span>)</p>
            
            <p class="h4"><?=($user_account->currency == 'EUR') ? number_format(usdToEur($currencies, $stock->latestPrice), 2, ".",",") : number_format(usdToEur($currencies, $stock->latestPrice) * $currencies[$user_account->currency], 2, ".",",") ?><?=(!$user_account->currency) ? "€" : CURRENCYSYMBOL[$user_account->currency];?></p>
        </div>
        <div class="row">
            <div class="col-lg-6 text-left">
                <p>Open: <span><?=($user_account->currency == 'EUR') ? number_format(usdToEur($currencies, $stock->open), 2, ".",",") : number_format(usdToEur($currencies, $stock->open) * $currencies[$user_account->currency], 2, ".",",")?><?=(!$user_account->currency) ? "€" : CURRENCYSYMBOL[$user_account->currency]?></span></p>

                <p>High: <span><?=($user_account->currency == 'EUR') ? number_format(usdToEur($currencies, $stock->high), 2, ".",",") : number_format(usdToEur($currencies, $stock->high) * $currencies[$user_account->currency], 2, ".",",")?><?=(!$user_account->currency) ? "€" : CURRENCYSYMBOL[$user_account->currency]?></span></p>

                <p>Low: <span><?=($user_account->currency == 'EUR') ? number_format(usdToEur($currencies, $stock->low), 2, ".",",") : number_format(usdToEur($currencies, $stock->low) * $currencies[$user_account->currency], 2, ".",",")?><?=(!$user_account->currency) ? "€" : CURRENCYSYMBOL[$user_account->currency]?></span></p>

                <p>Close: <span><?=($user_account->currency == 'EUR') ? number_format(usdToEur($currencies, $stock->close), 2, ".",",") : number_format(usdToEur($currencies, $stock->close) * $currencies[$user_account->currency], 2, ".",",")?><?=(!$user_account->currency) ? "€" : CURRENCYSYMBOL[$user_account->currency]?></span></p>
            </div>
            <div class="col-lg-6 text-left">
                <p>Week52 High: <?=($user_account->currency == 'EUR') ? number_format(usdToEur($currencies, $stock->week52High), 2, ".",",") : number_format(usdToEur($currencies, $stock->week52High) * $currencies[$user_account->currency], 2, ".",",")?><?=(!$user_account->currency) ? "€" : CURRENCYSYMBOL[$user_account->currency]?></p>

                <p>Week52 Low: <?=($user_account->currency == 'EUR') ? number_format(usdToEur($currencies, $stock->week52Low), 2, ".",",") : number_format(usdToEur($currencies, $stock->week52Low) * $currencies[$user_account->currency], 2, ".",",")?><?=(!$user_account->currency) ? "€" : CURRENCYSYMBOL[$user_account->currency]?></p>
            </div>
        </div>
    </div>
    <div class="col-lg-7">
        <p class="h4">Week Report</p>
        <div id="canvasGraph">
            <canvas id="stockCanvas" width="auto" height="auto"></canvas>
        </div>
    </div>
    <button type="button" class="mr-5" id="buyPop" data-toggle="modal" data-target="#modalPopUp">Buy Stock</button>
    <button type="button" id="sellPop" <?=($totalStocks < 1) ? "disabled" : "" ?> data-toggle="modal" data-target="#modalSellPopUp">Sell Stock</button>
</div>


