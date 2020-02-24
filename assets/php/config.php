<?php
    ## global site variables
    define("ROOT", "/Investus/");
    define("PROJECTNAME", "InvestUs");
    ## db variables
    define("DBHOST", "localhost");
    define("DBNAME", "investus");
    define("DBUSER", "root");
    define("DBPWD", "");
    ## curl variables
    define("APITOKEN", "pk_8a25f0355188420cbb82b582e3898ae8");
    define("CURRENCY", "https://api.exchangeratesapi.io/latest");
    ## update and create fetch with stocks info, time in seconds
    define("CREATE", 86400);
    define("UPDATE", 3600);
    ## phpmailer settings
    DEFINE('MAIL_SERVER', 'smtp.gmail.com');
    DEFINE('MAIL_PORT', 587);
    DEFINE('MAIL_USR', 'debugygor@gmail.com');
    DEFINE('MAIL_PWD', 'uHGvgU9hYFYZJEK');
    DEFINE('MAIL_SUBJECT', 'InvestUs | Password Reset');
    ## stocks and currency values
    define("STOCKARR", ['AAPL', 'AMZN', 'BBVA', 'F', 'FB', 'GOOG', 'IRBT', 'JPM', 'LULU', 'MSFT', 'NFLX', 'OKE', 'T', 'VZ', 'VTI', 'VXUS']);
    define("CURRENCYSYMBOL", [
        'EUR' => '€',
        'CAD' => '$',
        'HKD' => '$',
        'ISK' => 'kr',
        'PHP' => '&#8369;',
        'DKK' => 'kr',
        'HUF' => 'Ft',
        'CZK' => 'K&#269;',
        'AUD' => '$',
        'RON' => 'lei',
        'SEK' => 'kr',
        'IDR' => 'Rp',
        'INR' => 'INR',
        'BRL' => 'R$',
        'RUB' => '&#8381;',
        'HRK' => 'kn',
        'JPY' => '&#165;',
        'THB' => '&#3647;',
        'CHF' => 'CHF',
        'SGD' => '$',
        'PLN' => '&#122;&#322;',
        'BGN' => '&#1083;&#1074;',
        'TRY' => 'TRY',
        'CNY' => '&#165;',
        'NOK' => 'kr',
        'NZD' => '$',
        'ZAR' => 'R',
        'USD' => '$',
        'MXN' => '$',
        'ILS' => '&#8362;',
        'GBP' => '£',
        'KRW' => '&#8361;',
        'MYR' => 'RM'
    ]);
?>
