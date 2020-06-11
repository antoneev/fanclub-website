<?php
//Include the header
include("templates/header.php");
if (isset($_SESSION['loggedin'])) {
    header("Location: index.php");
}
?>

<h2>Login Form</h2>
<div class="container">
    <form action="login.php" method="POST">
        <p>Please Login to access certain features</p>
        <?php
        if (isset($_GET['error'])) {
            if ($_GET['error'] == "invalidpassword") {
                echo '<p class="error">Please check your password!</p>';
            } else if ($_GET['error'] == "nouser") {
                echo '<p class="error">No user was found with this username!</p>';
            } else if ($_GET['error'] == "lockedacc") {
                echo '<p class="error">Your account is currently locked, please contact the administrator!</p>';
            }
        }
        ?>
        <div class="row">
            <div class="col-25">
                <label for="username">Username: </label>
            </div>
            <div class="col-75">
                <input type="text" name="username" required="">
            </div>
        </div>
        <div class="row">
            <div class="col-25">
                <label for="password">Password: </label>
            </div>
            <div class="col-75">
                <input type="password" name="password" required="">
            </div>
        </div>
        <div class="row">
            <input class="LoginButton" type="submit" value="Login!" name="login">
        </div>
    </form>
</div>


<?php
//Include the footer
include("templates/footer.php");
?>

<?php
if (isset($_POST['login'])) {

    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    $sql = "select * from users where username = '" . $username . "'";
    $rs = mysqli_query($dbc, $sql);
    $numRows = mysqli_num_rows($rs);

    if ($numRows == 1) {
        $row = mysqli_fetch_assoc($rs);
        if ($row['status'] == 'LOCKED') {
            header("Location: login.php?error=lockedacc");
            exit();
        }
        if (password_verify($password, $row['password'])) {
            if ($row['admin'] == 'Y') {
                $_SESSION['admin'] = TRUE;
            }
            header("Location: index.php");
            $_SESSION['loggedin'] = TRUE;
            $_SESSION['username'] = $_POST['username'];
            exit();
        } else {
            header("Location: login.php?error=invalidpassword");
            exit();
        }
    } else {
        header("Location: login.php?error=nouser");
        exit();
    }
}
?>