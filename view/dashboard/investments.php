<div class="row ">
    <div class="col-md-12 shadow p-3 mb-5 bg-white rounded text-dark">
        <p class="h5">My stocks</p>
        <table class="table">
            <tr class="font-weight-bold">
                <th scope="col">NAME</th>
                <th scope="col">SYMBOL</th>
                <th scope="col">LAST</th>
                <th scope="col">%</th>
                <th scope="col">BUY PRICE</th>
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
                <td scope="row"><?= $userStock->latestPrice;?></td>
                <td scope="row" class="<?= ($userStock->changePercent*100 > 100) ?  "positive" :  "negative"?>"><?= round($userStock->changePercent*100, 2, PHP_ROUND_HALF_EVEN);?>%</td>
                <td scope="row"><?= $userStock->buy_price;?></td>
                <td scope="row"><?= $userStock->amount;?></td>
                <td scope="row"><?= $userStock->boughtAt;?></td>
            </tr>
            <?php } ?>
        </table>
    </div>
</div>