<div class="row ">
    <div class="col-md-12 shadow p-3 mb-5 bg-white rounded text-dark">
        <div class="row">
            <div class="col-md-8">
                <p class="h5">My stocks</p>
                <table class="table">
                    <tr>
                        <th scope="col">NAME</th>
                        <th scope="col">SYMBOL</th>
                        <th scope="col">LAST</th>
                        <th scope="col">%</th>
                    </tr>
                    <?php 
                        $userStocks = (new Stock)->getStocks($_SESSION['user_id']);
                        foreach($userStocks as $userStock) {
                    ?>
                    <tr>
                    </tr>
                    <?php } ?>
                </table>
            </div>
            <div class="col-md-4">
                <p class="h5">Funds log</p>
                <table class="table">
                    <tr>
                        <th scope="col">Value</th>
                        <th scope="col">Date</th>
                        <th scope="col">Action</th>
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
                        <td scope="row"><?=$log->createdAt?></td>
                        <td scope="row"><?=$log->action?></td>
                    </tr>
                        <?php  } ?>
                </table>
            </div>
        </div>
    </div>
</div>