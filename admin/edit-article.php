<?php

    require "../includes/init.php";
    session_start();

    $db = new Database();
    $conn = $db->getDB();
    Auth::requireLogin();

    

    if (isset($_GET["id"])) { 
        $article = Article::getArticleByID($conn, $_GET['id']);
        if(!$article){
        die('<h2>Invalid ID</h2> </br> Article not found');
        } elseif ($article) {
        }else{
            die('<h2>ID is missing...</h2> </br> Article not found.');
        }
    }

    $category_ids = array_column($article->getCategories($conn), 'id');
    $categories = Category::getAll($conn);

    if ($_SERVER["REQUEST_METHOD"] == "POST"){

        $article->title = $_POST['text'];
        $article->content = $_POST['content'];
        $article->published_at = $_POST['date'];
        $category_ids = $_POST['category'] ?? [];

        if($article->updateArticle($conn)){
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
    <title>Edit article</title>
</head>
<body>
    <h2>Edit Article</h2>
    <?php require 'includes/article-form.php'; ?>
</body>
</html>