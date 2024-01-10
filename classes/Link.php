<?php
class Link{
    /**
     * Redirects the user to another page
     * 
     * @param string link to the desired page
     * 
     * @return void
     */
    public static function redirect($link){
        if($_SERVER['HTTPS'] && $_SERVER['HTTPS'] != off){
            $protocol = 'https';
        }else{
            $protocol = 'http';
        }
        header("Location: $protocol://" . $_SERVER['HTTP_HOST'] . $link);
}
}

?>