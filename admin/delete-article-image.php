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
    if ($_SERVER["REQUEST_METHOD"] == "POST"){
        

        $previous_image = $article->image;

        if ($article->setImageFile($conn, null)){
            if($previous_image){
                unlink("../uploads/$previous_image");
            }
            Link::redirect("/cms_blog/admin/article.php?id={$article->id}");
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete article image</title>
</head>
<body>
    <h2>Delete article image</h2>
    <?php if($article->image): ?>
                <img src="../uploads/<?=$article->image?>" alt="Article image">
            <?php endif; ?>
    <?php if(!empty($error)){
        echo $error;
    }?>
    <form method="POST">
        <p>Are you sure?</p>
        <button>Delete</button>
    </form>
    <a href="/cms_blog/admin/article.php?id=<?=$_GET["id"];?>">Back</a>
</body>
</html>