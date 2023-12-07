<?php

    require "includes/database.php";
    require "includes/getArticleID.php";

    $conn = getDB();

    if (isset($_GET["id"])) { 
        $article = getArticleID($conn, $_GET['id']);
    } else {
        $article === null;
    };
?>
<!DOCTYPE html>
<html>
<head>
    <?php if (is_numeric($_GET["id"])):?>
        <title><?= $article['title']; ?></title>
    <?php else:?>
        <title> Page not found</title>
    <?php endif; ?>
    <meta charset="utf-8">
</head>
<body>
    <header>
        <a href="index.php">Back</a> 
        <br>
        <?php if (is_numeric($_GET["id"])):?>
            <h1><?= htmlspecialchars($article['title']); ?></h1>
        <?php else:?>
            <h1>Ooops...</h1>
        <?php endif; ?>
    </header>

    <main>
        <?php if ($article === null): ?>
            <p>Article not found.</p>
        <?php else: ?>
            <div>
                <p><?= htmlspecialchars($article['content']); ?></p>
            </div>
        <?php endif; ?>
        <a href="edit-article.php?id=<?=$_GET["id"];?>">Edit</a>
        <a href="delete-article.php?id=<?=$_GET["id"];?>">Delete</a>
    </main>
</body>
</html>
