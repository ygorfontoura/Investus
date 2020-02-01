<?php 
    require_once("model/base.php");
    class Stock{
        use Base;

        public string $symbol;
        public string $companyName;
        public string $updatedAt;
        public float $latestPrice;
        public float $changePercent;
        public float $buy_price;
        public int $amount;
        public string $boughtAt;
        public string $primaryExchange;
        public $open;
        public $close;
        public $high;
        public $low;
        public float $previousClose;
        public float $week52High;
        public float $week52Low;
        
        public function updateStocks($arr){
            $updateQuery = $this->db->prepare("SELECT id, stocks, updatedAt FROM stocks ORDER BY createdAt DESC LIMIT 1");
            $updateQuery->execute([]);
            $stockToUpdate = $updateQuery->fetch(PDO::FETCH_ASSOC);
            $stock_id = $stockToUpdate['id'];
            $arr = json_encode($arr);
            $query = $this->db->prepare(
                "UPDATE stocks
                SET stocks = ?
                WHERE id = ?
            ");
            $result = $query->execute([$arr, $stock_id]);
            return $result;
        }

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
        
        public function getStocks($user_id){
            $query = $this->db->prepare(
                "SELECT us.symbol, us.companyName, us.latestPrice, us.buy_price, us.amount, us.createdAt
                FROM user_stocks us
                WHERE user_id = ?
            ");
            $query->execute([$user_id]);
            $user_stocks = [];
            $entries = $query->fetchAll(PDO::FETCH_ASSOC);
            foreach($entries as $entry){
                $stock = new Stock;
                $stock->symbol = $entry['symbol'];
                $stock->companyName = $entry['companyName'];
                $stock->latestPrice = $entry['latestPrice'];
                $stock->changePercent = $entry['latestPrice']/$entry['buy_price'];
                $stock->buy_price = $entry['buy_price'];
                $stock->amount = $entry['amount'];
                $stock->boughtAt = $entry['createdAt'];
                array_push($user_stocks, $stock);
            };
            return $user_stocks;
        }

        public function getStockHistory($symbol){
            // $week = [];
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
                $entry = $json[0];
                $stock = new Stock;
                if($entry['symbol'] == $symbol) {
                    $stock->symbol = $entry['symbol'];
                    $stock->companyName = $entry['companyName'];
                    $stock->open = $entry['open'];
                    $stock->close = $entry['close'];
                    $stock->high = $entry['high'];
                    $stock->low = $entry['low'];
                    $stock->week52High = $entry['week52High'];
                    $stock->week52Low = $entry['week52Low'];
                    $stock->latestPrice = $entry['latestPrice'];
                    $stock->updatedAt = $entry['latestUpdate'];
                    $stock->changePercent = $entry['changePercent'];
                    $stock->primaryExchange = $entry['primaryExchange'];
                    $stock->previousClose = $entry['previousClose'];
                    $week[$i] = $stock;
                    $i++;
                }
            }
            return $week;
        }
    }
?>