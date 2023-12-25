<?php

    require "classes/Database.php";
    require "classes/Article.php";
    require "includes/redirect.php";

    $db = new Database();
    $conn = $db->getDB();

    if (isset($_GET["id"])) { 
        $article = Article::getArticleByID($conn, $_GET['id']);
        if(!$article){
        die('<h2>Invalid ID</h2> </br> Article not found');
        } elseif ($article) {
        }else{
            die('<h2>ID is missing...</h2> </br> Article not found.');
        }
    }
    if ($_SERVER["REQUEST_METHOD"] == "POST"){

        $article->title = $_POST['text'];
        $article->content = $_POST['content'];
        $article->published_at = $_POST['date'];

       if($article->updateArticle($conn)){
            redirect ("/cms_blog/article.php?id={$article->id}");
        } 
        
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit article</title>
</head>
<body>
    <h2>Edit Article</h2>
    <?php require 'includes/article-form.php'; ?>
</body>
</html>