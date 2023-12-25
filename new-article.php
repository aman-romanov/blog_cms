<?php

    require 'classes/Database.php';
    require "classes/Article.php";
    require "includes/redirect.php";

    $article = new Article;

    if ($_SERVER["REQUEST_METHOD"] == "POST"){

        $db = new Database();
        $conn = $db->getDB();

        $article->title = $_POST['text'];
        $article->content = $_POST['content'];
        $article->published_at = $_POST['date'];

       if($article->createArticle($conn)){
            redirect ("/cms_blog/article.php?id={$article->id}");
        } 
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New article</title>
</head>
<body>
    <h2>New article</h2>
    <?php require 'includes/article-form.php'; ?>
</body>
</html>