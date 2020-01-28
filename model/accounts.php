<?php
    trait Accounts{
        use Base;
        public function createAccount($user_id){
            $query = $this->db->prepare(
                "INSERT INTO accounts
                (user_id)
                VALUES
                (?)
            ");
            $result = $query->execute([$user_id]);
            return $result;
        }

        public function getAccount($user_id){
            $query = $this->db->prepare(
                "SELECT iban, balance, ccard, csc, expiresM, expiresY, currency
                 FROM accounts
                 WHERE user_id = ?
            ");
            $query->execute([$user_id]);
            $data = $query->fetch(PDO::FETCH_ASSOC);
            return $data;
        }

        public function addFunds($user_id, $data){
            $currency = getCurrency(CURRENCY); $currencies = $currency['rates'];
            $data = ($data['currency'] != 'EUR') ? $data['amount']/$currencies[$data['currency']] : $data['amount'];
            $query = $this->db->prepare(
                "UPDATE accounts
                SET balance = balance+?
                WHERE user_id = ?
            ");
            $result = $query->execute([$data, $user_id]);
            return $result;
        }

    }
?>