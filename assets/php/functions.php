<?php 
    function getBackground($json, $string){
        $backgrounds = json_decode(file_get_contents($json), true);
        return "../assets/images/backgrounds/".$string."/".$backgrounds[$string][Rand(0, count($backgrounds[$string])-1)];
    }
    function getStockList($data){
        $ch = curl_init($data);
        curl_setopt($ch, CURLOPT_URL, $data);
        $output = curl_exec($ch);
        curl_close($ch);
        return $output;
    }
    function getStocks($stocks){
        $stocks_json = [];
        foreach($stocks as $stock){
            $url = "https://cloud.iexapis.com/stable/stock/".$stock."/quote?token=".APITOKEN;
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $output = json_decode(curl_exec($ch), true);
            array_push($stocks_json, $output);
            curl_close($ch);
        }
        return $stocks_json;
    }
    function getCurrency($url){
        $currency = [];
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        return json_decode(curl_exec($ch), true);
    }
?>