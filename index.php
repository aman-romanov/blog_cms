<?php

    require "includes/database.php";
    require "includes/redirect.php";
    
    session_start();
    $conn = getDB();

    $sql = "SELECT *
            FROM articles
            ORDER BY published_at";

    $results = mysqli_query($conn, $sql);

    if ($results === false) {
        echo mysqli_error($conn);
    } else {
        $articles = mysqli_fetch_all($results, MYSQLI_ASSOC);
    }
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
            <br>
            <a href="login.php">Logout</a>
        <?php else{
            redirect(/php_course/login.php);
        } endif;?>
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
    </main>
</body>
</html>
