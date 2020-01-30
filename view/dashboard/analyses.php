<?php ##$stocks = (!empty($stocks)) ? $stocks :  getStocks($avaible_stocks_arr); ?>
<?php
    $stock = new Stock;
    $data = $stock->fetchStocks();
    $stocks = json_decode($data['stocks'], true);

    $date = strtotime($data['updatedAt']);
    $currentDate = date("U");
    $dateVerify = ($currentDate - $date <= 86400) ? "valid" : "update";
    if($dateVerify == "update") {
        $data = $stock->updateStocks(getStocks($avaible_stocks_arr));
        $data = $stock->fetchStocks();
        $stocks = json_decode($data['stocks'], true);
    }
    ?>
<div class="row">
    <div class="col-md-8 userpanel p-3 text-dark shadow p-3 mb-5 bg-white rounded">
        <p class="h5">Real Time Data</p>
        <div>
            <table class="table text-dark">
                <tr class="font-weight-bold">
                    <th scope="col">NAME</th>
                    <th scope="col">SYMBOL</th>
                    <th scope="col">MARKET</th>
                    <th scope="col">LAST</th>
                    <th scope="col">%</th>
                    <th scope="col">DATE / TIME</th>
                </tr>
                <?php
                    foreach($stocks as $stock){?>
                    <tr>
                        <td scope="row"><a href="<?=ROOT?>dashboard/stock/<?=strtolower($stock['symbol'])?>"><?=(!array_key_exists('companyName', $stock)) ? "N/A" : $stock['companyName']?></a></td>    
                        <td scope="row"><?=(!array_key_exists('symbol', $stock)) ? "N/A" : $stock['symbol']?></td>    
                        <td scope="row"><?=(!array_key_exists('primaryExchange', $stock)) ? "N/A" : $stock['primaryExchange'];?></td>    
                        <td scope="row"><?=(!array_key_exists('latestPrice', $stock)) ? "N/A" : $stock['latestPrice']?></td>    
                        <td scope="row" class="<?= ($stock['changePercent']*100 > 0) ?  "positive" :  "negative"?>"><?=round($stock['changePercent']*100, 2, PHP_ROUND_HALF_EVEN)?>%</td>    
                        <td scope="row"><?=(!array_key_exists('latestTime', $stock)) ? "N/A": $stock['latestTime']?></td>   
                    </tr>
                <?php }?>
            </table>
        </div>
    </div>
    <div class="col-md-4">
        <div>
            grafico xpto
        </div>
    </div>
</div>