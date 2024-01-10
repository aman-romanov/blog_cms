<?php
    require "includes/init.php";

    session_start();

    if ($_SERVER['REQUEST_METHOD'] == 'POST'){

        $db = new Database();
        $conn = $db->getDB();
        $user = new User();
        $user->username = $_POST['username'];
        $user->password = $_POST['password'];

        if (User::checkUsername($conn, $user->username)){
            if ($user->password == $_POST["password_confirmation"]) {
                if (User::register($conn, $user->username, $user->password)){
                    session_regenerate_id(true);
                    $_SESSION['is_logged_in'] = true;
                    Link::redirect('/cms_blog/index.php');
                }
            }else {
                $error = "Passwords must match";
            }
        } else{
            $error = "Username is taken";
        }
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
</head>
<body>
    <h2>Sign Up</h2>
    <a href="index.php">Back</a>
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
        <label for="password">Repeat password:</label>
        <input type="password" name='password_confirmation'>
        <br>
        <button>Sign Up</button>
        <a href="login.php">Already have account?</a>
    </form>
</body>
</html>