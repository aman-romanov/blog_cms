<?php

    require "classes/Database.php";
    require "classes/Article.php";
    require "includes/redirect.php";

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

    <main>
        <?php if(isset($_SESSION['is_logged_in']) && $_SESSION['is_logged_in']=true):?>
            <div>Welcome!</div>
            <br/>
            <a href="logout.php">Logout</a>
            <br/>
            <a href="new-article.php">Create new article</a>
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
        <?php else:?>
            <?php redirect('/cms_blog/login.php'); ?>
        <?php endif; ?>
    </main>
</body>
</html>