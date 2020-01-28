<?php 
    require_once("model/base.php");
    class Stock{
        use Base;
        
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
    }
?>