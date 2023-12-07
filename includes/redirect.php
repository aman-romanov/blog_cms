<?php
function redirect($link){
    if($_SERVER['HTTPS'] && $_SERVER['HTTPS'] != off){
        $protocol = 'https';
    }else{
        $protocol = 'http';
    }
    header("Location: $protocol://" . $_SERVER['HTTP_HOST'] . $link);
}

?>