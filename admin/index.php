<?php
    require "../includes/init.php";

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
    <?php require "../includes/header.php"; ?>
    <a href="/cms_blog/index.php">Back</a>
    <main>
        <?php if (empty($articles)): ?>
                <p>No articles found.</p>
            <?php else: ?>
                <table>
                    <tr>
                        <th>Content</th>
                    </tr>
                    <?php foreach ($articles as $article): ?>
                        <tr>
                            <td>
                                <a href="article.php?id=<?=$article['id'];?>"> <?= htmlspecialchars($article['title']); ?></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            <?php endif; ?>
    </main>
</body>
</html>