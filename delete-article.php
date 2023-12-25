<?php

    require "classes/Database.php";
    require "classes/Article.php";
    require "includes/redirect.php";

    $db = new Database();
    $conn = $db->getDB();

    if (isset($_GET["id"])) { 
        $article = Article::getArticleByID($conn, $_GET['id']);
        if(!$article){
        die('<h2>Invalid ID</h2> </br> Article not found');
        } elseif ($article) {
        }else{
            die('<h2>ID is missing...</h2> </br> Article not found.');
        }
    }
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        if ($article->deleteArticle($conn)) {
                redirect ("/cms_blog/index.php");
        }
    }
?>

<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Delete article?</title>
    </head>
    <body>
        <h2>Delete "<?=$article->title;?>"?</h2>
        <form method="POST">
            <button>Delete</button>
        </form>
        <a href="article.php?id=<?=$article->id;?>">Cancel</a>
    </body>
    </html>