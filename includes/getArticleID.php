<?php
/**
 * 
 * Get article content based on ID
 * 
 * @param object $conn is Connection to the DB
 * @param int $id is ID of the article
 * 
 * @return mixed An associatve array containing article of that ID or NULL if not found
 * 
 */
    function getArticleID($conn, $id){
        $sql="SELECT *
            FROM articles
            WHERE id = ?";

        $stmt = mysqli_prepare($conn, $sql);
        if ($stmt === false){
            echo mysqli_error($conn);

        }else{
            mysqli_stmt_bind_param($stmt, "i", $id);
            if (mysqli_stmt_execute($stmt)){
                $result = mysqli_stmt_get_result($stmt);
                return mysqli_fetch_array($result, MYSQLI_ASSOC);
            }
        }
    }
?>