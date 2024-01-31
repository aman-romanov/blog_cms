<?php   
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    
    require 'vendor/PHPMailer/src/Exception.php';
    require 'vendor/PHPMailer/src/PHPMailer.php';
    require 'vendor/PHPMailer/src/SMTP.php';

    $email = "";
    $title = "";
    $message ='';
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
        if(empty($errors)){
            $mail = new PHPMailer;
            try{
                $mail->CharSet = 'utf-8';

                // $mail->SMTPDebug = 3;                               // Enable verbose debug output

                $mail->isSMTP();                                      // Set mailer to use SMTP
                $mail->Host = 'smtp.mail.me.com';  // Specify main and backup SMTP servers
                $mail->SMTPAuth = true;                               // Enable SMTP authentication
                $mail->Username = 'Aman Romanov';                 // Наш логин
                $mail->Password = 'pmsl-wjby-bgch-jpqc';                           // Наш пароль от ящика
                $mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
                $mail->Port = 587;                                    // TCP port to connect to
                
                $mail->setFrom('CMS');   // От кого письмо 
                $mail->addReplyTo($email);
                $mail->addAddress('ouornek@icloud.com');     // Add a recipient
                $mail->isHTML(true);                         // Set email format to HTML

                $mail->Subject = $title;
                $mail->Body = $message;

                $mail->send();
                $sent = true;

            } catch(Exception $e){
                echo 'Message is not sent' . $mail->ErrorInfo;
            }
        }
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
       <?php $email = "";
        $title = "";
        $message ='';?>
    <?php endif;?>
    <h2>Contact us</h2>
    <?php  if(!empty($errors) ): ?>
    <ul>
        <?php foreach ($errors as $error):?>
        <li><?= $error; ?></li>
        <?php endforeach; ?>
    </ul>
<?php endif;?>
    <form method="post" id="contactForm">
        <div>
            <label for="">Your Email</label>
            <input placeholder="Email" name="email" id="email" value="<?=htmlspecialchars($email);?>">
        </div>
        <div>
            <label for="title">Title</label>
            <input placeholder="Title" name="title" id="title" value="<?=htmlspecialchars($title);?>">
        </div>
        <div>
            <label for="message">Message</label>
            <textarea name="message" id="message" placeholder="Message" value="<?=htmlspecialchars($message);?>"></textarea>
        </div>

        <button>Send</button>
    </form>
    <a href="/cms_blog/admin/index.php">Back</a>

    <script   src="https://code.jquery.com/jquery-3.7.1.min.js"   integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo="   crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js" ></script>
    <script src="js/script.js"></script>
</body>
</html>