<?php
require "includes/redirect.php";

session_start();

if ($_SERVER['REQUEST_METHOD'] = 'POST'){
    if ($_POST['username'] = "aman" && $_POST['password'] = "password"){
        $_SESSION['is_logged_in'] = 'true';
        redirect(/blog_cms/index.php);
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