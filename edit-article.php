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
    if ($_SERVER["REQUEST_METHOD"] == "POST"){

        $title = $_POST['text'];
        $content = $_POST['content'];
        $date = $_POST['date'];

        $error = validateArticle($title, $content, $date);

        if(empty($error)){
            $sql = "UPDATE articles
                    SET title = ?,
                    content = ?,
                    published_at = ?
                    WHERE id = ?";

            $stmt = mysqli_prepare($conn, $sql);

            if ($stmt === false){
                echo mysqli_error($conn);
            } else {
                if($date == ''){
                    $date = null;
                }
                mysqli_stmt_bind_param ($stmt, "sssi", $title, $content, $date, $id);
                if (mysqli_stmt_execute($stmt)) {
                    redirect ("/php_course/article.php?id=$id");
                } else {
                    mysqli_stmt_error($stmt);
                }
            }
        }
    };
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit article</title>
</head>
<body>
    <h2>Edit Article</h2>
    <?php require 'includes/article-form.php'; ?>
</body>
</html>