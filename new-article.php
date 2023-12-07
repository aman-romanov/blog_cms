<?php

    require 'includes/database.php';
    require "includes/validate-form.php";
    require "includes/redirect.php";

    $title ='';
    $content ='';
    $date = '';
    if ($_SERVER["REQUEST_METHOD"] == "POST"){

        $title = $_POST['text'];
        $content = $_POST['content'];
        $date = $_POST['date'];

        $error = validateArticle($title, $content, $date);

        if(empty($error)){
            $conn = getDB();

            $sql = "INSERT INTO articles (title, content, published_at)
                    VALUES (?,?,?)";
    
            $stmt = mysqli_prepare($conn, $sql);
    
            if ($stmt === false){
                echo mysqli_error($conn);
            } else {
                if($date == ''){
                    $date = null;
                }
                mysqli_stmt_bind_param ($stmt, "sss", $title, $content, $date);
                if (mysqli_stmt_execute($stmt)) {
                    $id = mysqli_insert_id($conn);
                    redirect ("/php_course/article.php?id=$id");
                } else {
                    mysqli_stmt_error($stmt);
                }
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New article</title>
</head>
<body>
    <h2>New article</h2>
    <?php require 'includes/article-form.php'; ?>
</body>
</html>