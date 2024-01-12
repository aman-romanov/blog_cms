<?php

    require "includes/init.php";

    $db = new Database();
    $conn = $db->getDB();

    if (isset($_GET["id"])) { 
        $article = Article::getArticleByID($conn, $_GET['id']);
    } else {
        $article === null;
    };
?>
<!DOCTYPE html>
<html>
<head>
    <?php if ($article):?>
        <title><?= $article->title; ?></title>
    <?php else:?>
        <title> Page not found</title>
    <?php endif; ?>
    <meta charset="utf-8">
</head>
<body>
    <header>
        <a href="index.php">Back</a> 
        <br>
        <?php if ($article):?>
            <h1><?= htmlspecialchars($article->title); ?></h1>
            <?php if($article->image): ?>
                <img src="uploads/<?=$article->image?>" alt="Article image">
            <?php endif; ?>
        <?php else:?>
            <h1>Ooops...</h1>
        <?php endif; ?>
    </header>

    <main>
        <?php if ($article): ?>
            <div>
                <p><?= htmlspecialchars($article->content); ?></p>
            </div>
        <?php else: ?>
            <p>Article not found.</p>
        <?php endif; ?>
    </main>
</body>
</html>
