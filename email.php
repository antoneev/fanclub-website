<?php
//Include the header
include("templates/header.php");
include("../config.php");
if (!isset($_SESSION['loggedin'])) {
    header("Location: index.php");
}
require 'phpmailer/PHPMailerAutoload.php';
?>

<h2>Email Form</h2>
<div class="container">
    <form action="email.php" method="POST">
        <?php
        if (isset($_GET['error'])) {
            if ($_GET['error'] == "emailnotsend") {
                echo '<p class="error">Email did not send!</p>';
            }
        }
        if (isset($_GET['success'])) {
            if ($_GET['success'] == "emailsend") {
                echo '<p class="success">Email was sent!</p>';
            }
        }
        ?>
        <div class="row">
            <div class="col-25">
                <label for="email">My Email: </label>
            </div>
            <div class="col-75">
                <input type="email" name="email" required="">
            </div>
        </div>
        <div class="row">
            <div class="col-25">
                <label for="subject">Subject: </label>
            </div>
            <div class="col-75">
                <input type="text" name="subject" required="">
            </div>
        </div>
        <div class="row">
            <div class="col-25">
                <label for="message">Message</label>
            </div>
            <div class="col-75">
                <textarea name="message" required="" style="height:200px"></textarea>
            </div>
        </div>
        <div class="row">
            <input class="BookContactButton" type="submit" value="Submit" name="submit">
        </div>
    </form>
</div>


<?php
include("templates/footer.php");
// Include the footer
?>

<?php
if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $subjuct = $_POST['subject'];
    $message = $_POST['message'];

    $mail = new PHPMailer;
    $mail->isSMTP();
    $mail->SMTPAuth = true;
    //$mail->SMTPDebug = 1;   // debug set to 1, 2, or 3 to show more or less details for error messages

    $mail->Host = $host;       // host name for email service                              
    $mail->Username = $username;                 // username for email account you can have the @ extension or leave it off                  
    $mail->Password = $password;                 // password for email account
    $mail->SMTPSecure = $SMTPsecure;
    $mail->Port = $port;

    $mail->addAddress('aevan7@uis.edu');                // Add a recipient
    $mail->FromName = $email;            // the name you want to appear
    $mail->Subject = $subjuct;              // Subject
    $mail->Body = $message;           // Message

    if (!$mail->send()) {
        header("Location: email.php?error=emailnotsend");
        exit();
    } else {
        header("Location: email.php?success=emailsend");
        exit();
    }
}    
