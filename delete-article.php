<?php

    require "includes/database.php";
    require "includes/getArticleID.php";
    require "includes/validate-form.php";
    require "includes/redirect.php";

    $conn = getDB();

    if (isset($_GET["id"])) { 
        $article = getArticleID($conn, $_GET['id']);
        if($article){
            $title = $article['title'];
            $content = $article['content'];
            $date = $article['published_at'];
            $id = $article['id'];
        } else{
            die('<h2>Invalid ID</h2> </br> Article not found');
        }
    } else {
        die('<h2>ID is missing...</h2> </br> Article not found.');
    };
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $sql = "DELETE FROM articles
                WHERE id = ?";
        $stmt = mysqli_prepare($conn, $sql);
        if ($stmt === false){
            echo mysqli_error($conn);
        } else {
            mysqli_stmt_bind_param ($stmt, "i", $id);
            if (mysqli_stmt_execute($stmt)) {
                redirect ("/php_course/index.php");
            } else {
                mysqli_stmt_error($stmt);
            }
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
        <h2>Delete "<?=$title;?>"?</h2>
        <form method="POST">
            <button>Delete</button>
        </form>
        <a href="article.php?id=<?=$id;?>">Cancel</a>
    </body>
    </html>