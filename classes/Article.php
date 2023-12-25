<?php
/**
 * Article class
 */
class Article {
    public $id;
    public $title;
    public $content;
    public $published_at;
    public $error;

    /**
     * Get all the articles
     * 
     * @param object $conn Connection to the DB
     * @return array An associative array of all the articles sorted by their date
     */
    public static function getAll($conn){
        $sql = "SELECT *
        FROM articles
        ORDER BY published_at";

        $results = $conn->query($sql);
        return $results->fetchAll(PDO::FETCH_ASSOC);
    }
    /**
     * 
     * Get article content based on ID
     * 
     * @param object $conn is Connection to the DB
     * @param int $id is ID of the article
     * 
     * @return mixed An object of the Article class or NULL if not found
     * 
     */
    public static function getArticleByID($conn, $id){
        $sql="SELECT *
            FROM articles
            WHERE id = :id";

        $stmt = $conn->prepare($sql);

        $stmt->bindValue(':id', $id, PDO::PARAM_INT);

        $stmt -> setFetchMode(PDO::FETCH_CLASS, 'Article');

        if ($stmt->execute()){
            return $stmt->fetch();
        }
    }
    /**
     * 
     * Creates article on the server side through form
     * 
     * @param object $conn is Connection to the DB
     * 
     * @return boolean True if changes are succcesfull or False otherwise
     * 
     */
    public function updateArticle($conn){
        if ($this->validateArticle()){
            $sql = "UPDATE articles
                    SET title = :title,
                    content = :content,
                    published_at = :published_at
                    WHERE id = :id";
            $stmt = $conn->prepare($sql);

            $stmt->bindValue(':id', $this->id, PDO::PARAM_INT);
            $stmt->bindValue(':content', $this->content, PDO::PARAM_STR);
            $stmt->bindValue(':title', $this->title, PDO::PARAM_STR);
            if($this->published_at == ""){
                $stmt->bindValue(':published_at', null, PDO::PARAM_NULL);
            }else{
                $stmt->bindValue(':published_at', $this->published_at, PDO::PARAM_STR);
            }
            return $stmt->execute();
        }else{
            return false;
        }
    }

    /**
     * 
     * Validates that every submitted information is correct
     * 
     * @param object $conn is Connection to the DB
     * 
     * @return object An object of the errors made while filling the article
     * 
     */
    protected function validateArticle(){
        
        if ($this->title == ''){
            $this->error[] = "Article title is required!";
        }
        if ($this->content == ''){
            $this->error[] = "Article content is not filled!";
        }

        if($this->published_at != ""){
            $date_time = date_create_from_format('Y-m-d H:i:s', $this->published_at);
            if($date_time === false){
                $this->error[] = 'Invalid date and time';
            }else{
                $date_errors = date_get_last_errors();
                if($date_errors['warning_count'] > 0){
                    $this->error[] = 'Invalid date and time';
                }
            }
        }

        return empty($this->error);
    }
    /**
     * 
     * Deletes article row by id
     * 
     * @param object $conn is Connection to the DB
     * 
     * @return boolean True if changes are succcesfull or False otherwise
     * 
     */
    public function deleteArticle($conn){
        $sql = "DELETE FROM articles
                WHERE id = :id";

        $stmt = $conn->prepare($sql);

        $stmt->bindValue(':id', $this->id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    /**
     * 
     * Updates article information on the server side through form
     * 
     * @param object $conn is Connection to the DB
     * 
     * @return boolean True if changes are succcesfull or False otherwise
     * 
     */
    public function createArticle($conn){
        if ($this->validateArticle()){
            $sql = "INSERT INTO articles (title, content, published_at)
            VALUES (:title, :content, :published_at)";
            $stmt = $conn->prepare($sql);

            $stmt->bindValue(':content', $this->content, PDO::PARAM_STR);
            $stmt->bindValue(':title', $this->title, PDO::PARAM_STR);
            if($this->published_at == ""){
                $stmt->bindValue(':published_at', null, PDO::PARAM_NULL);
            }else{
                $stmt->bindValue(':published_at', $this->published_at, PDO::PARAM_STR);
            }
            if ($stmt->execute()){
                $this->id = $conn->lastInsertId();
                return true;
            };
        }else{
            return false;
        }
    }
}