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
        try{
            switch($_FILES['file']['error']){
                case UPLOAD_ERR_OK:
                    break;
                case UPLOAD_ERR_NO_FILE:
                    throw new Exception ("File is not uploaded");
                    break;
                case UPLOAD_ERR_INI_SIZE:
                    throw new Exception ("Max allowed image size 2M");
                    break;
                default:
                    throw new Exception ("Error");
                    break;
            }

            $mime_types = ['image/jpg', 'image/jpeg', 'image/png'];
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $mime_type = finfo_file($finfo, $_FILES['file']['tmp_name']);
            if(!in_array($mime_type,$mime_types)){
                $error = "Image must be in format of jpeg/jpg/png";
            }

            $pathinfo = pathinfo($_FILES['file']['name']);
            $base = $pathinfo['filename'];
            $base = preg_replace('/[^a-zA-Z0-9_-]/', '_', $base);
            $filename = $base . "." . $pathinfo['extension'];
            $destination = "../uploads/$filename";

            $i = 1;
            while(file_exists($destination)){
                $filename = $base . "-$i." . $pathinfo['extension'];
                $destination = "../uploads/$filename";
                $i++;
            }

            if(move_uploaded_file($_FILES['file']['tmp_name'], $destination)){

                $previous_image = $article->image;

                if ($article->setImageFile($conn, $filename)){
                    if($previous_image){
                        unlink("../uploads/$previous_image");
                    }
                    Link::redirect("/cms_blog/admin/article.php?id={$article->id}");
                }
                
            }else{
                throw new Exception ("Error ocurred while uploading");
            }
        } catch(Exception $e){
            $error = $e->getMessage();
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit article image</title>
</head>
<body>
    <h2>Edit article image</h2>
    <?php if($article->image): ?>
        <img src="../uploads/<?=$article->image?>" alt="Article image">
    <?php endif; ?>
    <?php if(!empty($error)){
        echo $error;
    }?>
    <form method="post" enctype="multipart/form-data">
        <div>
            <label for="file">Choose file:</label>
            <input type="file" id="file" name="file">
        </div>
        <button>Upload</button>
    </form>
    <?php if($article->image): ?>
        <a class="delete" href="/cms_blog/admin/delete-article-image.php?id=<?=$_GET["id"];?>">Delete</a>
    <?php endif; ?>
    <a href="/cms_blog/admin/article.php?id=<?=$_GET["id"];?>">Back</a>
    <script   src="https://code.jquery.com/jquery-3.7.1.min.js"   integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo="   crossorigin="anonymous"></script>
    <script src="../js/script.js"></script>
</body>
</html>