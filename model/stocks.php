<?php 
    require_once("model/base.php");
    class Stock{
        use Base;

        public $symbol;
        public $name;
        public $updatedAt;
        public $latestPrice;
        public $changePercent;
        public $buy_price;
        public $amount;
        public $boughtAt;
        
        public function updateStocks($arr){
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
                "SELECT s.stocks, s.updatedAt, s.id 
                FROM stocks s 
                ORDER BY updatedAt DESC 
            ");
            $query->execute([]);
            $data = $query->fetchAll(PDO::FETCH_ASSOC);
            return $data[0];
        }

        public function getStock($symbol){
            $stocks = json_decode($this->fetchStocks()['stocks'], true);
            
            foreach($stocks as $stock){ 
                if($stock['symbol'] == 'FB') return $stock;
            }

           // return $symbol;
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
    }
?>