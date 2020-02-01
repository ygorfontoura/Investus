<div class="row userpanel p-3 text-dark shadow p-3 mb-5 bg-white rounded justify-content-center">
    <div class="col-md-5">
        <p class="h4">Information</p>
        <?php $stock = $stock->getStock($detail);?>

        <div class="text-left">
            <p class="h5"><?=$stock->companyName?></p>

            <p><?=$stock->primaryExchange?> : <?=$stock->symbol?> <?php
                                                                    $close = (!empty($stock->open)) ? $stock->open : $stock->previousClose;
                                                                    echo number_format($stock->latestPrice - $close, 2);
                                                                    ?>
            <span>(<?=number_format($stock->changePercent * 100, 2)?>%</span>)</p>
            
            <p class="h4"><?=($user_account->currency == 'EUR') ? number_format($stock->latestPrice / $currencies['USD'], 2, ".",",") :number_format($stock->latestPrice / $currencies['USD'] * $currencies[$user_account->currency], 2, ".",",") ?>$</p>
        </div>
        <div class="row">
            <div class="col-md-6 text-left">
                <p>Open: <span><?=($user_account->currency == 'EUR') ? number_format($stock->open / $currencies['USD'], 2, ".",",") : number_format($stock->open / $currencies['USD']  * $currencies[$user_account->currency], 2, ".",",")?><?=(!$user_account->currency) ? "€" : $currency_symbols[$user_account->currency]?></span></p>

                <p>High: <span><?=($user_account->currency == 'EUR') ? number_format($stock->high / $currencies['USD'], 2, ".",",") : number_format( $stock->high / $currencies['USD'] * $currencies[$user_account->currency], 2, ".",",")?><?=(!$user_account->currency) ? "€" : $currency_symbols[$user_account->currency]?></span></p>

                <p>Low: <span><?=($user_account->currency == 'EUR') ? number_format($stock->low / $currencies['USD'], 2, ".",",") : number_format( $stock->low / $currencies['USD'] * $currencies[$user_account->currency], 2, ".",",")?><?=(!$user_account->currency) ? "€" : $currency_symbols[$user_account->currency]?></span></p>

                <p>Close: <span><?=($user_account->currency == 'EUR') ? number_format($stock->close / $currencies['USD'], 2, ".",",") : number_format($stock->close / $currencies['USD'] * $currencies[$user_account->currency], 2, ".",",")?><?=(!$user_account->currency) ? "€" : $currency_symbols[$user_account->currency]?></span></p>
            </div>
            <div class="col-md-6 text-left">
                <p>Week52 High: <?=($user_account->currency == 'EUR') ? number_format($stock->week52High / $currencies['USD'], 2, ".",",") : number_format($stock->week52High / $currencies['USD'] * $currencies[$user_account->currency], 2, ".",",")?><?=(!$user_account->currency) ? "€" : $currency_symbols[$user_account->currency]?></p>

                <p>Week52 Low: <?=($user_account->currency == 'EUR') ? number_format($stock->week52Low / $currencies['USD'], 2, ".",",") : number_format($stock->week52Low / $currencies['USD'] * $currencies[$user_account->currency], 2, ".",",")?><?=(!$user_account->currency) ? "€" : $currency_symbols[$user_account->currency]?></p>
            </div>
        </div>
    </div>
    <div class="col-md-7">
        Week Report
    </div>
    <button type="button">Buy Stock</button>
    <button type="button">Sell Stock</button>
</div>

