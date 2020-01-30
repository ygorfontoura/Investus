<?php
    class Transaction{
        use Base;
        
        public $user_id;
        public $action;
        public $value;
        public $buy_price;
        public $createdAt;

        public function createLog($user_id, $data){
            $query = $this->db->prepare(
            "INSERT INTO transaction_log
            (user_id, action, value, buy_price)
            VALUES
            (?, ?, ?, ?)
            ");
            $result = $query->execute([
                $user_id,
                $data['action'],
                $data['amount'],
                $data['buy_price']
            ]);
            return $result;
        }
        
        public function getLogs($user_id){
            $query = $this->db->prepare(
                "SELECT t.action, t.value, t.buy_price, t.createdAt
                FROM transaction_log t
                WHERE user_id = ?
                ORDER BY createdAt DESC"
            );
            $query->execute([$user_id]);
            $logs =  [];
            $entries = $query->fetchAll(PDO::FETCH_ASSOC);
            foreach($entries as $entry){
                $newlog = new Transaction;
                $newlog->action = $entry['action'];
                $newlog->value = $entry['value'];
                $newlog->buy_price = $entry['buy_price'];
                $newlog->createdAt = $entry['createdAt'];
                array_push($logs, $newlog);
            }
            return $logs; 
        }
    }

?>