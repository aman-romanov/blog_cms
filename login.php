<?php
require "includes/redirect.php";

session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    if ($_POST['username'] == "aman" && $_POST['password'] == "password"){
        session_regenerate_id(true);
        $_SESSION['is_logged_in'] = true;
        redirect('/cms_blog/index.php');
    } else{
        $error = "Invalid username or password";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <h2>Login</h2>
    <?php if(! empty($error)): ?>
        <div><?=$error;?></div>
    <?php endif;?>
    <form method='POST'>
        <label for="username">Username:</label>
        <input type="text" name='username'>
        <br>
        <label for="password">Password:</label>
        <input type="password" name='password'>
        <br>
        <button>Login</button>
    </form>
</body>
</html>