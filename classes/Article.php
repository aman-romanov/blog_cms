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
    public $image;

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
     * Pagination of the articles
     * 
     * @param object $conn Connection to the DB
     * @param int $limit Number of desired articles
     * @param int $offset Number of articles to skip
     * 
     * 
     * @return array An associative array of all the articles sorted by their date
     */
    public static function getByPage($conn, $limit, $offset){
        $sql = "SELECT *
        FROM articles
        ORDER BY published_at
        LIMIT :limit
        OFFSET :offset";

        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);

        $stmt->execute();

        return $stmt -> fetchAll(PDO::FETCH_ASSOC);
    }
     /**
     * Get total number of the articles
     * 
     * @param object $conn Connection to the DB
     * @return int Total number of records
     */
    public static function getArticlesNum($conn){
        return $conn->query('SELECT COUNT(*) FROM articles')->fetchColumn();
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
    /**
     * 
     * Updates article's cover image with uploaded file from user
     * 
     * @param object $conn is Connection to the DB
     * @param string $filename Name of the image file
     *
     * @return boolean True if changes are succcesfull or False otherwise
     * 
     */
    public function setImageFile($conn, $filename){
        $sql = "UPDATE articles
                SET image = :image
                WHERE id = :id";
        
        $stmt = $conn->prepare($sql);

        $stmt->bindValue(":image", $filename, $filename == null ? PDO::PARAM_NULL : PDO::PARAM_STR);
        $stmt->bindValue(":id", $this->id, PDO::PARAM_INT);

        return $stmt->execute();
    }
}