<?php   

    $email = "";
    $title = "";
    $message = "";
    $sent = false;

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $email = $_POST['email'];
        $title = $_POST['title'];
        $message = $_POST['message'];

        $errors = [];
        if(filter_var($email, FILTER_VALIDATE_EMAIL) === false){
            $errors[] = "Please enter a valid email address!";
        }
        if ($title == ''){
            $errors[] = "Title is required!";
        }
        if ($message == ''){
            $errors[] = "Message is not filled!";
        }

        $sent = true;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact</title>
</head>
<body>
    <?php  if($sent): ?>
        <p>Message sent</p>
    <?php endif;?>
    <h2>Contact us</h2>
    <?php  if(!empty($errors) ): ?>
    <ul>
        <?php foreach ($errors as $error):?>
        <li><?= $error; ?></li>
        <?php endforeach; ?>
    </ul>
<?php endif;?>
    <form method="post" id="formContact">
        <div>
            <label for="">Your Email</label>
            <input placeholder="Email" name="email" id="email" value="<?=htmlspecialchars($email);?>">
        </div>
        <div>
            <label for="title">Title</label>
            <input placeholder="Title" name="title" id="title" value="<?=htmlspecialchars($title);?>">
        </div>
        <div>
            <label for="">Message</label>
            <textarea name="message" id="message" placeholder="Message"> <?=htmlspecialchars($message);?> </textarea>
        </div>

        <button>Send</button>
    </form>
</body>
</html>