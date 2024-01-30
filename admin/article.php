<?php

    require "../includes/init.php";

    $db = new Database();
    $conn = $db->getDB();

    if (isset($_GET["id"])) { 
        $article = Article::getWithCategories($conn, $_GET['id']);
    } else {
        $article === null;
    };
?>
<!DOCTYPE html>
<html>
<head>
    <?php if ($article):?>
        <title><?= $article['0']['title']; ?></title>
    <?php else:?>
        <title> Page not found</title>
    <?php endif; ?>
    <meta charset="utf-8">
</head>
<body>
    <header>
        <a href="/cms_blog/admin/index.php">Back</a> 
        <br>
        <?php if ($article):?>
            <h1><?= htmlspecialchars($article['0']['title']); ?></h1>
            <?php if($article['0']['category_name']):?>
                <?php foreach($article as $a):?>
                    <p><?=htmlspecialchars($a['category_name']);?></p>
                <?php endforeach;?>
            <?php endif;?>
            <?php if($article['0']['image']): ?>
                <img src="../uploads/<?=$article['0']['image'];?>" alt="Article image">
            <?php endif; ?>
        <?php else:?>
            <h1>Ooops...</h1>
        <?php endif; ?>
    </header>

    <main>
        <?php if ($article): ?>
            <div>
                <?= htmlspecialchars($article['0']['content']); ?>
            </div>
        <?php else: ?>
            <p>Article not found.</p>
        <?php endif; ?>
        <a href="edit-article.php?id=<?=$article['0']['id'];?>">Edit</a>
        <a class="delete" href="delete-article.php?id=<?=$article['0']['id'];?>">Delete</a>
        <a href="edit-article-image.php?id=<?=$article['0']['id'];?>">Edit image</a>
    </main>
    <script   src="https://code.jquery.com/jquery-3.7.1.min.js"   integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo="   crossorigin="anonymous"></script>
    <script src="../js/script.js"></script>
</body>
</html>
