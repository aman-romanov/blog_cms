<?php
/** 
*   Connects to the database
*
*   @return connection to MYSQL db
*/
    function getDB() {
        $db_host = "localhost";
        $db_name = "blog_cms";
        $db_user = "tester";
        $db_pass = "vOJ1Cls7Q52GTIaT";
    
        $conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);
    
        if (mysqli_connect_error()) {
            echo mysqli_connect_error();
            exit;
        };

        return $conn;

    }
?>