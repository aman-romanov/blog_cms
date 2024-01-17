<?php
    /**
     * Article categories
     */
    class Category{
        /**
         * Get all the categories
         * 
         * @param object $conn Connection to the DB
         * @return array An associative array of all the categories sorted by their id
         */
        public static function getAll($conn){
            $sql = "SELECT *
            FROM category
            ORDER BY id";

            $results = $conn->query($sql);
            return $results->fetchAll(PDO::FETCH_ASSOC);
        }
    }

?>