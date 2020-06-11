<?php
//Include the header
include("templates/header.php");
if (!isset($_SESSION['loggedin'])) {
    header("Location: quotes.php");
}
?>

<?php
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM quotes WHERE id =" . $id;
    $result = mysqli_query($dbc, $sql);
    $row = mysqli_fetch_array($result);
}
//Update Information
if (isset($_POST['submit'])) {
    if (isset($_POST['fav'])) {
        $checkbox = $_POST['fav'];
    } else {
        $checkbox = "N";
    }
    $author = $_POST['author'];
    $quote = $_POST['quote'];

    $update = "UPDATE quotes SET text='$quote', author='$author', favorite='$checkbox' WHERE id='$id'";
    $up = mysqli_query($dbc, $update);
    if (!isset($up)) {
        header("location: update_quote.php?error=notupdated");
        exit();
    } else {
        header("location: update_quote.php?success=updated");
        exit();
    }
}
?>

<?php
if (isset($_GET['id'])) {
    ?>
    <h2>Update Quote</h2>
    <div class="container">   
        <form method="POST">
            <div class="row">
                <div class="col-25">
                    <label for="author">Author: </label>
                </div>
                <div class="col-75">
                    <input type="text" name="author" value="<?php echo $row['author']; ?>" required="">
                </div>
            </div>
            <div class="row">
                <div class="col-25">
                    <label for="quote">Quote:</label>
                </div>
                <div class="col-75">
                    <textarea name="quote" required="" style="height:200px"><?php echo $row['text']; ?></textarea>
                </div>
                <div class="col-75">
                    <input type="checkbox" 
                    <?php
                    if ($row['favorite'] == 'Y') {
                        echo 'checked="checked"';
                    }
                    ?>
                           name="fav" value="Y">
                    <label for="fav"> Check to add as a favorite</label><br>
                </div>
            </div>
            <div class="row">
                <input class="BookContactButton" type="submit" value="Update Quote!" name="submit">
            </div>
        </form>
    </div>

    <?php
}
if (isset($_GET['success'])) {
    if ($_GET['success'] == "updated") {
        echo '<p class="success">The quote has been updated!</p>';
    }
}
if (isset($_GET['error'])) {
    if ($_GET['error'] == "notupdated") {
        echo '<p class="error">Quote not updated!</p>';
    }
}
?>

<?php
include("templates/footer.php");
// Include the footer
?>