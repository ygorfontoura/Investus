<?php
    class Transaction{
        use Base;
        
        public $user_id;
        public $action;
        public $value;
        public $symbol;
        public $buy_price;
        public $createdAt;

        ## create a log 
        public function createLog($user_id, $data){
            $data['amount'] = (isset($data['amount'])) ? $data['amount'] : NULL;
            $data['symbol'] = (isset($data['symbol'])) ? $data['symbol'] : NULL;
            $data['buy_price'] = (isset($data['buy_price'])) ? $data['buy_price'] : NULL;
            $query = $this->db->prepare(
            "INSERT INTO transaction_log
            (user_id, action, value, symbol, buy_price, amount, currencyUsed, currencyValue)
            VALUES
            (?, ?, ?, ?, ?, ?, ?, ?)
            ");
            $result = $query->execute([
                $user_id,
                $data['action'],
                $data['value'],
                $data['symbol'],
                $data['buy_price'],
                $data['amount'],
                $data['currencyUsed'],
                $data['currencyValue']
            ]);
            return $result;
        }
        ## get logs by user id, optional camps to sort by action input
        public function getLogs($user_id, $opt = NULL, $opt1 = NULL){
            if(isset($opt) || isset($opt1)) {
                $query = $this->db->prepare(
                    "SELECT t.action, t.value, t.symbol, t.buy_price, t.createdAt, t.amount, t.currencyUsed, t.currencyValue
                    FROM transaction_log t
                    WHERE user_id = ?
                    AND t.action = ? 
                    OR user_id = ?
                    AND t.action = ?
                    ORDER BY createdAt DESC");
                $query->execute([$user_id, $opt, $user_id, $opt1]);
                $entries = $query->fetchAll(PDO::FETCH_ASSOC);
            } else {
                $query = $this->db->prepare(
                    "SELECT t.action, t.value, t.symbol, t.buy_price, t.createdAt, t.amount, t.currencyUsed, t.currencyValue
                    FROM transaction_log t
                    WHERE user_id = ?
                    ORDER BY createdAt DESC
                    ");
                $query->execute([$user_id]);
                $entries = $query->fetchAll(PDO::FETCH_ASSOC);
            };
            
            $logs =  [];
            foreach($entries as $entry){
                $newlog = new Transaction;
                $newlog->action = $entry['action'];
                $newlog->value = $entry['value'];
                $newlog->symbol = $entry['symbol'];
                $newlog->buy_price = $entry['buy_price'];
                $newlog->createdAt = $entry['createdAt'];
                $newlog->amount = $entry['amount'];
                $newlog->currencyUsed = $entry['currencyUsed'];
                $newlog->createcurrencyValueAt = $entry['currencyValue'];
                array_push($logs, $newlog);
            }
            return $logs; 
        }
    }

?>