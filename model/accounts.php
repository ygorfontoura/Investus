<?php
    class Accounts{
        use Base;

        public $iban;
        public $balance;
        public $ccard;
        public $csc;
        public $expiresM;
        public $expiresY;
        public $currency;

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
            $this->iban = $data['iban'];
            $this->balance = $data['balance'];
            $this->ccard = $data['ccard'];
            $this->csc = $data['csc'];
            $this->expiresM = $data['expiresM'];
            $this->expiresY = $data['expiresY'];
            $this->currency = $data['currency'];
            return $this;
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

        // public function removeData($user_id, $data){
        //     $query = $this->db->prepare(
        //         "DELETE $data
        //         FROM accounts
        //         WHERE user_id = ?"
        //     );
        //     $query->execute([$data['type'], $user_id]);
        //     return true;
        // }

        public function update($user_id, $data){
            
            $data = $this->sanitize($data);
            $query = $this->db->prepare(
                "UPDATE accounts
                SET iban = ?,
                    ccard = ?,
                    csc = ?,
                    expiresM = ?,
                    expiresY = ?,
                    currency = ?
                WHERE user_id = ?
            ");
            $result = $query->execute([
                $data['iban'],
                $data['ccard'],
                $data['csc'],
                $data['expiresM'],
                $data['expiresY'],
                $data['currency'],
                $user_id
            ]);
            return $result;
        }

    }
?>