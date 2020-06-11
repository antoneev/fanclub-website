<?php
//Include the header
include("templates/header.php");
if (isset($_SESSION['loggedin'])) {
    header("Location: index.php");
}
?>

<h2>Register Form</h2>
<div class="container">
    <form action="register.php" method="POST">
        <p>Please register to access certain features</p>
        <?php
        if (isset($_GET['error'])) {
            if ($_GET['error'] == "passwordsdontmatch") {
                echo '<p class="error">Passwords do not match!</p>';
            } else if ($_GET['error'] == "usernametaken") {
                echo '<p class="error">Username already exists please use another!</p>';
            }
        } else if (isset($_GET['register'])) {
            if ($_GET['register'] == "success") {
                echo '<p class="success">You are now register! Click <a href="login.php">Here</a> to log in</p>';
            }
        }
        ?>
        <div class="row">
            <div class="col-26">
                <label for="username">Username: </label>
            </div>
            <div class="col-75">
                <input type="text" name="username" required="">
            </div>
        </div>
        <div class="row">
            <div class="col-26">
                <label for="password">Password: </label>
            </div>
            <div class="col-75">
                <input type="password" name="password" required="">
            </div>
        </div>
        <div class="row">
            <div class="col-26">
                <label for="c-password">Confirm Password: </label>
            </div>
            <div class="col-75">
                <input type="password" name="c_password" required="">
            </div>
        </div>
        <div class="row">
            <input class="RegisterButton" type="submit" value="Register" name="register">
        </div>
    </form>
</div>


<?php
//Include the footer
include("templates/footer.php");
?>

<?php
if (isset($_POST['register'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $c_password = $_POST['c_password'];
    $status = "OPEN";
    $admin = "N";

    $sql = "SELECT username FROM users WHERE username='$username'";
    $result = mysqli_query($dbc, $sql);

    if ($password != $c_password) {
        header("Location: register.php?error=passwordsdontmatch");
        exit();
    } else if (mysqli_num_rows($result) == 1) {
        header("Location: register.php?error=usernametaken");
        exit();
    } else {
        $hash_password = password_hash($password, PASSWORD_DEFAULT);

        $insert_user = "INSERT INTO users (username, password, user_dir, status, admin)
        VALUES ('$username','$hash_password','$username','$status','$admin')";

        $query = mysqli_query($dbc, $insert_user);

        $dir = $_POST['username'];
        mkdir('../users/' . $dir, 0700);
        $file_pointer = fopen('../users/' . $dir . "/books.csv", "w");

        if ($query) {
            header("Location: register.php?register=success");
            exit();
        }
    }
}
?>