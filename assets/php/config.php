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

    $avaible_stocks_arr = ['cur', 'altr', 'cpa', 'cor', 'ctt', 'fen', 'jmt', 'lit', 'mar', 'egl', 'phr', 'sem', 'son', 'nvg'];
    $currency_symbols = [
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
    ];

    ##  unavaible $portuguese_stocks_arr = ['cur', 'altr', 'cpa', 'cor', 'ctt', 'fen', 'jmt', 'lit', 'mar', 'egl', 'phr', 'sem', 'son', 'nvg', 'bcp', 'slben', 'cfn', 'cdu', 'edp', 'edpr', 'eson', 'enxp', 'mlfmv', 'flexd', 'fcp', 'galp', 'glint', 'ibs', 'gpa', 'ipr', 'ina', 'lig','mcp', 'mrl', 'mlmr','mlm24', 'alnor', 'nos', 'nba', 'ore', 'alptr', 'mlrze', 'ram', 'red', 'rene', 'scb', 'sonc', 'soni', 'snc', 'sng', 'scp', 'tdsa', 'sct', 'vaf'];
?>
