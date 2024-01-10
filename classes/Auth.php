<?php
    class Auth {
        /**
         * Checks authorization of a user based on the session code
         * 
         * @return boolean True or false
         */
        public static function isLoggedIn(){
            return isset($_SESSION['is_logged_in']) && $_SESSION['is_logged_in'];
        }
        /**
         * Blocks permission to the page based on authorization
         * 
         * @return void simply redirects to the index page
         */
        public static function requireLogin(){
            if(!static::isLoggedIn()){
                Link::redirect("/cms_blog/index.php");
            }
        }
    }
?>