<?php

    require "../includes/init.php";

    session_start();

    $article = new Article;
    Auth::requireLogin();

    $category_ids = [];
    $db = new Database();
    $conn = $db->getDB();
    $categories = Category::getAll($conn);
    

    if ($_SERVER["REQUEST_METHOD"] == "POST"){

        $article->title = $_POST['text'];
        $article->content = $_POST['content'];
        $article->published_at = $_POST['date'];
        $category_ids = $_POST['category'] ?? [];

        if($article->createArticle($conn)){
            $article->setCategories($conn, $category_ids);
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