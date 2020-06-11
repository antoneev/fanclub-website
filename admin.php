<?php
//Include the header
include("templates/header.php");
if (!isset($_SESSION['admin'])) {
    header("Location: index.php");
}
?>

<?php if (!isset($_POST['submit']) && !isset($_POST['change'])) { ?>
    <h2>Administrator Functions</h2>
    <div class="container">
        <div class="row">
            <div class="col-25">

                <form method="POST">  
                    <label for="username">Username: </label>
            </div>

            <?php
            echo '<div class="col-75" class="adminDropdown">
                    <select name="user">';

            $sqli = "SELECT * FROM users";
            $result = mysqli_query($dbc, $sqli);
            while ($row = mysqli_fetch_array($result)) {
                if ($row['username'] == $_SESSION['username']) {
                    continue;
                }
                echo '<option value=' . $row['username'] . '>' . $row['username'] . '</option>';
            }
            echo '</select></div>';
            ?>
        </div>
        <input class="BookContactButton" type="submit" value="Submit!" name="submit">
        </form>
    </div>
<?php } ?>



<?php
if (isset($_POST['submit'])) {
    $sqli = "SELECT * FROM users";
    $result = mysqli_query($dbc, $sqli);
    $row = mysqli_fetch_array($result);
    ?>
    <h1>Administrator Function</h1>
    <p>Username:
        <?php
        $user = $_POST['user'];
        echo " <b>" . $user . "</b></p>";
        $selectAdmin = "SELECT admin FROM users WHERE username='$user'";
        $changed = mysqli_query($dbc, $selectAdmin);
        $rowadmin = mysqli_fetch_array($changed);

        $selectStat = "SELECT status FROM users WHERE username='$user'";
        $stat = mysqli_query($dbc, $selectStat);
        $rowstat = mysqli_fetch_array($stat);
        ?>

    <h3>Account Options:</h3>
    <form method="POST">

        <input type="radio" 
        <?php
        if ($rowstat['status'] == 'OPEN') {
            echo 'checked="checked"';
        }
        ?>
               name="option" value="OPEN">
        <label for="OPEN">Open</label><br>
        <input type="radio" 
        <?php
        if ($rowstat['status'] == 'LOCKED') {
            echo 'checked="checked"';
        }
        ?>
               name="option" value="LOCKED">
        <label for="LOCKED">Locked</label><br>
        <?php if ($rowadmin['admin'] == 'N') { ?>
            <input type="radio" name="option" value="Y">
            <label for="Y">Grant Administration Role</label><br>
        <?php } ?>
        <?php if ($rowadmin['admin'] == 'Y') { ?>
            <input type="radio" name="option" value="N">
            <label for="N">Remove Administration Role</label><br>
        <?php } ?>
        <input type="radio" name="option" value="deleteacc">
        <label for="deleteacc">Delete This Account</label><br>
        <input class="FileButton" type="submit" value="Submit Changes!" name="change">
        <input type="hidden" name="forwardData" value="<?php echo $user ?>">

    </form>


    <?php
}
if (isset($_POST['change'])) {
    $sqli = "SELECT * FROM users";
    $result = mysqli_query($dbc, $sqli);
    $row = mysqli_fetch_array($result);
    $user = $_POST['forwardData'];
    echo '<h2>Account Status</h2>';
    $selectStatus = $_POST['option'];
    if ($selectStatus == 'OPEN' || $selectStatus == 'LOCKED') {

        $changeStatus = "UPDATE users SET status='$selectStatus' WHERE username='$user'";
        $changed = mysqli_query($dbc, $changeStatus);
        if (!isset($changed)) {
            header('refresh: 4, admin.php');
            echo '<p class="error">Error the users status was not updated!</p>';
            exit();
        } else {
            if ($selectStatus == "OPEN") {
                header('refresh: 4, admin.php');
                echo '<p class="success">The account <b>' . $user . '</b> is now OPEN!</p>';
                exit();
            } else {
                header('refresh: 4, admin.php');
                echo '<p class="success">The account <b>' . $user . '</b> is now LOCKED!</p>';
                exit();
            }
        }
    } elseif ($selectStatus == 'Y' || $selectStatus == 'N') {
        $changeAdmin = "UPDATE users SET admin='$selectStatus' WHERE username='$user'";
        $change = mysqli_query($dbc, $changeAdmin);
        if (!isset($change)) {
            header('refresh: 4, admin.php');
            echo '<p class="error">Error the users status was not updated!</p>';
            exit();
        } else {
            if ($selectStatus == "Y") {
                header('refresh: 4, admin.php');
                echo '<p class="success">The Administrator Role has been added to the Account! <b>' . $user . '</b></p>';
                exit();
            } else {
                header('refresh: 4, admin.php');
                echo '<p class="success">The Administrator Role has been revoked from the Account! <b>' . $user . '</b></p>';
                exit();
            }
        }
    } elseif ($selectStatus == 'deleteacc') {
        $delete = "DELETE FROM users WHERE username ='$user'";
        $deleted = mysqli_query($dbc, $delete);
        // PHP program to delete all 
        // file from a folder 
        // Folder path to be flushed 
        $folder_path = "../users/" . $user;

        // List of name of files inside 
        // specified folder 
        $files = glob($folder_path . '/*');

        // Deleting all the files in the list 
        foreach ($files as $file) {

            if (is_file($file))

            // Delete the given file 
                unlink($file);
        }
        rmdir('../users/' . $user);
        if (!isset($deleted)) {
            header('refresh: 4, admin.php');
            echo '<p class="error">Error the users status was not updated!</p>';
            exit();
        } else {
            header('refresh: 4, admin.php');
            echo '<p class="success">The account <b>' . $user . '</b> is now deleted!</p>';
            exit();
        }
    }
}
?>



<?php
include("templates/footer.php");
// Include the footer
?>