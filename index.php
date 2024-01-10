<?php
    require "includes/init.php";

    session_start();

    $db = new Database();
    $conn = $db->getDB();

    $articles = Article::getAll($conn);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Blog</title>
    <meta charset="utf-8">
</head>
<body>

    <header>
        <h1>Fishy blog</h1>
    </header>
    <?php require "includes/header.php"; ?>
    <main>
        <?php if (empty($articles)): ?>
            <p>No articles found.</p>
        <?php else: ?>
            <ul>
                <?php foreach ($articles as $article): ?>
                    <li>
                        <article>
                            <h2><a href="article.php?id=<?=$article['id'];?>"> <?= htmlspecialchars($article['title']); ?></a></h2>
                        </article>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </main>
</body>
</html>