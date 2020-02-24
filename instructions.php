<?php
    $url_parts = explode("/", $_SERVER["REQUEST_URI"]);
    $initial = array_search("Investus", $url_parts);
    $c = $initial+1;
    $a = $c+1;
    $d = $a+1;
    $html = '
    &lt;?php
        session_start();
        include("assets/php/config.php");
        

        $controllers = ["auth", "home", "ajax", "dashboard"];
        $controller = "home";

        $url_parts = explode("/", $_SERVER["REQUEST_URI"]);
        if(isset($url_parts['.$c.']) && in_array($url_parts['.$c.'], $controllers)){
            $controller = $url_parts['.$c.'];
            if(isset($url_parts['.$a.'])){
                $action = $url_parts['.$a.'];
            }
            if(isset($url_parts['.$d.'])){
                $detail = $url_parts['.$d.'];
            }
        }
        if($_SERVER["QUERY_STRING"] && $controller == "auth"){
            $action = strtok($action, "?");
            if($action == "forgot"){
                $key = explode("=", $_SERVER["QUERY_STRING"]);
                if($key[0] != "forgot_key") header("Location:".ROOT);
                require("view/newpwd.php");
            }
        }
        require("controller/" .$controller. ".php");
    ?&gt;';


    echo '
<body style="background-color: black; color: green; max-width: 100vw; height: 100vh; margin: 0; padding: 0">
    <h2>1. Copy the following code below and replace in index.php</h2>
    <hr>
<pre>
<code>
    '.$html.'
</code>
</pre>
    <h3>RAW Paste Data:</h3>
    <textarea style="margin-left: 5%; width:90%; height: 30vh; background-color: black; color: green; border:1px solid green">'.$html.'</textarea>
    <h2>2. Change define variables in assets/php/config.php</h2>
    <hr>
    <pre>
    <code>
    define("DBUSER", {USERNAME});
    define("DBPWD", {PASSWORD});
    </code>
    </pre>
</body>';
?>

