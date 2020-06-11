<?php
session_start();
include("../mysqli_connect.php");
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <title>Raise High the Roof Beam!</title>
        <link rel="stylesheet" href="css/style.css">
    </head>

    <body>

        <header>
            <ul class="headerUL">
                <li><a href="index.php" class="title">Raise High the Roof Beam!</a></li>
                    <?php
                    if (isset($_SESSION['loggedin'])) {
                        echo '
                <li style="float:right"><a href="logout.php">Logout</a></li>';
                        if (isset($_SESSION['admin'])) {
                            echo '<li style="float:right"><a href="admin.php">Admin</a></li>';
                        };
                        echo' <li style="float:right"><a href="upload.php">Uploads</a></li>
                <li style="float:right"><a href="email.php">Contact</a></li>
                <li style="float:right"><a href="quotes.php">Quotes</a></li>
                <li style="float:right"><a href="stories.php">Stories</a></li>
                <li style="float:right"><a href="books.php">Books</a></li>
                    ';
                    } else {
                        echo'
                        <li style="float:right"><a href="register.php">Register</a></li>
                        <li style="float:right"><a href="login.php">Login</a></li>
                        <li style="float:right"><a href="quotes.php">Quotes</a></li>
                        <li style="float:right"><a href="books.php">Books</a></li>
                        ';
                    }
                    ?>
            </ul>
        </header>


        <hr>

