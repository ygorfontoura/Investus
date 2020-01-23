<?php 
    function getBackground($json){
        $backgrounds = json_decode(file_get_contents($json), true);
        return "../assets/images/backgrounds/login/".$backgrounds['login'][Rand(0, count($backgrounds['login'])-1)];
    }
?>