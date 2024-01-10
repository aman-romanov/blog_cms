<?php

    require "../includes/init.php";

    session_start();

    $article = new Article;
    Auth::requireLogin();
    if ($_SERVER["REQUEST_METHOD"] == "POST"){

        $db = new Database();
        $conn = $db->getDB();

        $article->title = $_POST['text'];
        $article->content = $_POST['content'];
        $article->published_at = $_POST['date'];

        if($article->createArticle($conn)){
            Link::redirect ("/cms_blog/admin/article.php?id={$article->id}");
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