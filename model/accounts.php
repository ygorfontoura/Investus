<?php
    require("transactions.php");
    class Account{
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
            $data['amount'] = ($data['currency'] != 'EUR') ? $data['amount']/$currencies[$data['currency']] : $data['amount'];
            $query = $this->db->prepare(
                "UPDATE accounts
                SET balance = balance+?
                WHERE user_id = ?
            ");
            $result = $query->execute([$data['amount'], $user_id]);
            $data['action'] = 'Funds added';
            $data['buy_price'] = NULL;
            (new Transaction)->createLog($user_id, $data);
            return $result;
        }

        public function removeData($user_id, $data){
            if($data == "iban") {
                $query = $this->db->prepare(
                "UPDATE accounts
                SET iban = ?
                WHERE user_id = ?");
                return $query->execute([NULL, $user_id]);
            } elseif($data == "ccard"){
                $query = $this->db->prepare(
                    "UPDATE accounts
                     SET ccard = ?,
                        csc = ?,
                        expiresM = ?,
                        expiresY = ?
                     WHERE user_id = ?");
                return $query->execute([NULL, NULL, NULL, NULL, $user_id]);
            } else { return false;}
        }

        public function update($user_id, $data){
            $data = $this->sanitize($data);
            $current = $this->getAccount($user_id);
            (empty($data['iban'])) ? $data['iban'] = $this->iban : $data['iban'];
            (empty($data['ccard'])) ? $data['ccard'] = $this->ccard : $data['ccard'];
            (empty($data['csc'])) ? $data['csc'] = $this->csc : $data['csc'];
            (empty($data['expiresM'])) ? $data['expiresM'] = $this->expiresM : $data['expiresM'];
            (empty($data['expiresY'])) ? $data['expiresY'] = $this->expiresY : $data['expiresY'];
            (empty($data['currency'])) ? $data['currency'] = $this->currency : $data['currency'];
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