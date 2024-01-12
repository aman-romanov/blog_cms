<?php
    require "includes/init.php";

    session_start();

    $db = new Database();
    $conn = $db->getDB();

    $paginator = new Paginator($_GET['page'] ?? 1, 5, Article::getArticlesNum($conn));
    $articles = Article::getByPage($conn, $paginator->limit, $paginator->offset);
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
        <nav>
            <ul>
                <?php if($paginator->prev):?>
                    <li><a href="?page=<?=$paginator->prev?>">Prev</a></li>
                <?php else:?>
                    <li><p>Prev</p></li>
                <?php endif;?>
                <?php if($paginator->next):?>
                    <li><a href="?page=<?=$paginator->next?>">Next</a></li>
                <?php else:?>
                    <li><p>Next</p></li>
                <?php endif;?>
            </ul>
        </nav>
    </main>
</body>
</html>