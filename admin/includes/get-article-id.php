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

        $stmt = $conn->prepare($sql);

        $stmt->bindValue('?', $id, PDO::PARAM_INT);

        if ($stmt->execute()){
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
    }
?>