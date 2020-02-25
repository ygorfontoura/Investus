<?php 

    require_once("model/base.php");
    include_once("accounts.php");
    include_once("transactions.php");

    class Stock{
        use Base;

        public $id;
        public $symbol;
        public $companyName;
        public $updatedAt;
        public $latestPrice;
        public $changePercent;
        public $buy_price;
        public $amount;
        public $boughtAt;
        public $primaryExchange;
        public $open;
        public $close;
        public $high;
        public $low;
        public $previousClose;
        public $week52High;
        public $week52Low;
        ## update stocks every X hours, default: 1h
        public function updateStocks($arr){
            $updateQuery = $this->db->prepare("SELECT id, stocks, updatedAt FROM stocks ORDER BY createdAt DESC LIMIT 1");
            $updateQuery->execute([]);
            $stockToUpdate = $updateQuery->fetch(PDO::FETCH_ASSOC);
            $stock_id = $stockToUpdate['id'];
            $arr = json_encode($arr);
            $query = $this->db->prepare(
                "UPDATE stocks
                SET stocks = ?, updatedAt = ?
                WHERE id = ?
            ");
            $result = $query->execute([$arr, NULL, $stock_id]);
            return $result;
        }
        ## create a new stock in stocks every X hours, default: 24h
        public function createStocks($arr){
            $arr = json_encode($arr);
            $query = $this->db->prepare(
                "INSERT INTO stocks
                (stocks)
                VALUES
                (?)
            ");
            $result = $query->execute([$arr]);
            return $result;
        }
        ## get all stocks from databse
        public function fetchStocks(){
            $query = $this->db->prepare(
                "SELECT s.stocks, s.updatedAt, s.id, s.createdAt 
                FROM stocks s 
                ORDER BY createdAt DESC 
            ");
            $query->execute([]);
            $data = $query->fetchAll(PDO::FETCH_ASSOC);
            return $data[0];
        }
        ## get stock by given symbol
        public function getStock($symbol){
            $stocks = json_decode($this->fetchStocks()['stocks'], true);
            foreach($stocks as $stock){ 
                if($stock['symbol'] == $symbol) {
                    $this->symbol = $stock['symbol'];
                    $this->companyName = $stock['companyName'];
                    $this->open = $stock['open'];
                    $this->close = $stock['close'];
                    $this->high = $stock['high'];
                    $this->low = $stock['low'];
                    $this->week52High = $stock['week52High'];
                    $this->week52Low = $stock['week52Low'];
                    $this->latestPrice = $stock['latestPrice'];
                    $this->updatedAt = $stock['latestUpdate'];
                    $this->changePercent = $stock['changePercent'];
                    $this->primaryExchange = $stock['primaryExchange'];
                    $this->previousClose = $stock['previousClose'];
                    return $this;
                }
            }
        }
        ## get all stocks owned by user, optional arg to group 
        public function getStocks($user_id, $opt = NULL){
            if(is_null($opt)) {
                $query = $this->db->prepare(
                    "SELECT us.symbol, us.buy_price, us.amount, us.createdAt, id
                FROM users_stock us
                WHERE user_id = ?
                AND us.amount > 0
                ORDER BY createdAt DESC
                ");
                $query->execute([$user_id]);
            } else {
                $query = $this->db->prepare(
                    "SELECT us.symbol, AVG(buy_price) as buy_price, SUM(amount) as amount, us.createdAt, id
                    FROM users_stock us
                    WHERE user_id = ?
                    AND us.symbol = ?
                    AND us.amount > 0
                    GROUP BY us.symbol
                    ORDER BY us.symbol ASC
                ");
                $query->execute([$user_id, $opt]);
            }
            $user_stocks = [];
            $entries = $query->fetchAll(PDO::FETCH_ASSOC);
            foreach($entries as $entry){
                $stock = new Stock;
                $stock->symbol = $entry['symbol'];
                $stock->buy_price = $entry['buy_price'];
                $stock->amount = $entry['amount'];
                $stock->boughtAt = $entry['createdAt'];
                $stock->id = $entry['id'];
                array_push($user_stocks, $stock);
            };
            return $user_stocks;
        }
        ## function to get stock history by given symbol
        public function getStockHistory($symbol){
            include_once("assets/php/functions.php");
            $fetch = getCurrency(CURRENCY);
            $usd = $fetch['rates']['USD'];
            $week = [ [0], [1], [2], [3], [4], [5], [6] ];
            $i = 0;
            $query = $this->db->prepare(
                "SELECT stocks, updatedAt
                FROM stocks
                ORDER BY createdAt DESC LIMIT 7
            ");
            $query->execute([]);
            $entries = $query->fetchAll(PDO::FETCH_ASSOC);
            foreach($entries as $entry){
                $json = json_decode($entry['stocks'], true);
                $j = array_search($symbol, array_column($json, 'symbol'));
                if($j) {
                    $use = $json[$j];
                    $stock = new Stock;
                    $stock->symbol = $json[$j]['symbol'];
                    $stock->companyName = $json[$j]['companyName'];
                    $stock->open = ($json[$j]['open']) ? $json[$j]['open']/$usd : $json[$j]['previousClose']/$usd;
                    $stock->close = ($json[$j]['close']) ? $json[$j]['close']/$usd : $json[$j]['previousClose']/$usd;
                    $stock->high = $json[$j]['high']/$usd;
                    $stock->low = $json[$j]['low']/$usd;
                    $stock->week52High = $json[$j]['week52High']/$usd;
                    $stock->week52Low = $json[$j]['week52Low']/$usd;
                    $stock->latestPrice = $json[$j]['latestPrice']/$usd;
                    $stock->updatedAt = $json[$j]['latestUpdate'];
                    $stock->changePercent = $json[$j]['changePercent'];
                    $stock->primaryExchange = $json[$j]['primaryExchange'];
                    $stock->previousClose = $json[$j]['previousClose']/$usd;
                    $week[$i] = $stock;
                    $i++;
                }
            }
            echo json_encode($week);
            return $week;
        }
        ## function to buy a stock, insert into users_stocks, transactions_log and update accounts
        function buyStock($user_id, $stock){
            include_once("assets/php/functions.php");
            $amount = $stock['amount'];
            if($amount <= 0) { echo json_encode(array("success" => false, "reason" => "Invalid amount.")); return false;}

            ##verify user account
            $acc = (new Account)->getAccount($user_id);
            $user_currency = $acc->currency;
            $balance = $acc->balance;
            $fetch = getCurrency(CURRENCY);
            $currencies = $fetch['rates'];
            $currencyValue = ($user_currency != 'EUR') ? $currencies[$user_currency] : 1;
            $usd = $currencies['USD'];
            
            $symbol = $stock['symbol'];
            $stock = self::getStock($symbol);
            $stockPrice = $stock->latestPrice / $usd;
            $totalPurchase = $stockPrice * $amount;
            
            $affordable = ($balance >= $totalPurchase) ? true : false;

            ##create a purchase in users_stock db
            if($affordable){
                $query = $this->db->prepare(
                    "INSERT INTO users_stock
                    (user_id, symbol, buy_price, amount)
                    VALUES
                    (?, ?, ?, ?)
                ");
                $query->execute([
                    $user_id,
                    $symbol,
                    $stockPrice,
                    $amount,
                ]);

                ##create a log
                $transaction = new Transaction;
                $data = [];
                $data['action'] = "Stock Purchase";
                $data['buy_price'] = $stockPrice;
                $data['amount'] = $amount;
                $data['symbol'] = $symbol;
                $data['value'] = $totalPurchase;
                $data['currencyUsed'] = $user_currency;
                $data['currencyValue'] = $currencyValue;
                $transaction->createLog($user_id, $data);
                
                ##update users account balance
                $query = $this->db->prepare(
                    "UPDATE accounts
                     SET balance = balance - ?
                     WHERE user_id = ? 
                ");
                $query->execute([$totalPurchase, $user_id]);
                $result = array("symbol" => $symbol, "total" => $totalPurchase, "amount" => $amount, 'user_currency' => $user_currency, 'currency_value' => $currencyValue, 'success' => true);
                echo json_encode($result);
                return true;
            } else {
                $result = array("success" => false, "reason" => "Insufficient funds.");
                echo json_encode($result);
                return false;
            }
        }
        ## get how many stocks action user ha
        public function getUserStock($user_id, $symbol){
            $query = $this->db->prepare(
                "SELECT us.symbol, us.buy_price, us.amount, us.createdAt, id, (SELECT SUM(amount) FROM users_stock WHERE user_id = ? AND symbol = ?) as total
                FROM users_stock us
                WHERE user_id = ?
                AND us.symbol = ?
                AND us.amount > 0
            ");
            $query->execute([$user_id, $symbol, $user_id, $symbol]);
            $result = $query->fetchAll(PDO::FETCH_ASSOC); 
            return $result;
        }
        ##function to sell stock
        public function sellStock($user_id, $stock){
            include_once("assets/php/functions.php");
            $sellAmount = $stock['amount'];
            $symbol = $stock['symbol'];
            if($sellAmount <= 0) { echo json_encode(array("success" => false, "status" => 400, "reason" => "Invalid amount.")); return false;}

            ##get how many stocks is user able to sell
            $failMsg = array('success' => false, "reason" => "Not enough actions.");
            $userStocks = self::getUserStock($user_id, $symbol);
            $totalAvaible = $userStocks[0]['total'];
            $sellable = ($sellAmount <= $totalAvaible) ? true : false;
            if(!$sellable) { echo json_encode($failMsg);return false; }
            else {
                ##success message
                $msg = $sellAmount. " action(s) has been sold.";
                
                ## users_stock
                $stocksByUser = self::getStocks($user_id, $symbol);
                $actualAmount = $sellAmount;
                
                ##global values
                $actionsValue = $sellAmount * $userStocks[0]['buy_price'];
                ##update tables
                ##loop to update entries at users_stock
                foreach($userStocks as $stock){
                    $id = $stock['id'];
                    $valueQuery = $this->db->prepare("SELECT * FROM users_stock WHERE id = ? AND symbol = ? AND amount > 0");
                    $valueQuery->execute([$id, $symbol]);
                    $result = $valueQuery->fetch(PDO::FETCH_ASSOC);
                    $getMaxValue = $result['amount'];
                    if($actualAmount <= 0) { }
                    elseif($getMaxValue - $actualAmount < 0){
                        $queryS = $this->db->prepare(
                            "UPDATE users_stock SET amount = amount-? WHERE id = ?
                        ");
                        $queryS->execute([$getMaxValue, $id]);
                        $actualAmount -= $getMaxValue;
                    }
                    else{
                        $query = $this->db->prepare(
                            "UPDATE users_stock SET amount = amount-? WHERE id = ?
                        ");
                        $query->execute([$actualAmount, $id]);
                        $actualAmount -= $getMaxValue;
                    }
                };
                $fetch = getCurrency(CURRENCY);
                $currencies = $fetch['rates'];

                ##get user account info
                $acc = (new Account)->getAccount($user_id);
                $user_currency = $acc->currency;
                $balance = $acc->balance;
                $convertedValue = ($user_currency == 'EUR') ? $actionsValue : $actionsValue*$currencies[$user_currency];
                $currencyValue = ($user_currency == 'EUR') ? 1 : $currencies[$user_currency];
                ##update user balance
                $balanceQuery = $this->db->prepare(
                    "UPDATE accounts 
                    SET balance = balance + ?
                    WHERE user_id = ?
                ");
                $balanceQuery->execute([$actionsValue, $user_id]);

                ##create a transfer log
                $transaction = new Transaction;
                $data = array("action" => "Stock sold", "amount" => $sellAmount, "symbol" => $symbol, "value" => $actionsValue, "currencyUsed" => $user_currency, "currencyValue" => $currencyValue);
                $transaction->createLog($user_id, $data);

                ##return results
                $result = array("success" => true, "message" => $msg, "symbol" => $symbol, "amount" => $sellAmount, "value" => $actionsValue, "convertedValue" => $convertedValue, "currencyUsed" => $user_currency,"currencyValue" => $currencyValue);
                echo json_encode($result);
                return true;
            };
            
        }
    }
?>