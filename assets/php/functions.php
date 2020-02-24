<?php 
    ## function to generate a random background from a json file
    function getBackground($json, $string){
        $backgrounds = json_decode(file_get_contents($json), true);
        return "../assets/images/backgrounds/".$string."/".$backgrounds[$string][Rand(0, count($backgrounds[$string])-1)];
    }
    ## function to get all stocks symbol from internal file
    function getStockList($data){
        $ch = curl_init($data);
        curl_setopt($ch, CURLOPT_URL, $data);
        $output = curl_exec($ch);
        curl_close($ch);
        return $output;
    }
    ## function to fetch api most recent values
    function getStocks($stocks){
        $stocks_json = [];
        while(count($stocks_json) < count($stocks)){
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
    }
    ## function to get currencies
    function getCurrency($url){
        $currency = [];
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        return json_decode(curl_exec($ch), true);
    }
    ##$arr = array com valores das moedas, $currency = moeda do usuario, $value = valor a ser convertido
    function convertCurrency($arr, $currency, $value){
        if($currency != 'EUR'){
            return $value * $arr[$currency];
        } else { 
            return $value;
        }
    }
    ##$arr = array com valores das moedas, $value = valor a ser conertido
    function usdToEur($arr, $value){
        return $value / $arr['USD'];
    }
    ##resize image
    function resize_image($file) {
        $path = "public/users_avatar/";
        $tmp = explode("/", $file);
        $name = end($tmp);
        list($width, $height) = getimagesize($file);
        $r = ($width <= $height) ? $width : $height;

        $src = imagecreatefromjpeg($file);
        $crop = imagecrop($src, ['x' => 0, 'y' => 0, 'width' => $r, 'height' => $r]);
        $final = imagejpeg($crop, $path.$name, 100);

        return $final;
    }
?>

