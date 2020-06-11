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
//Delete Information
if (isset($_POST['submit'])) {

    $delete = 'DELETE FROM quotes WHERE id =' . $id;
    if (mysqli_query($dbc, $delete)) {
        header("location: delete_quote.php?success=deleted");
        exit();
    } else {
        header("location: update_quote.php?error=notdeleted");
        exit();
    }
    mysqli_close($conn);
}
?>

<?php
if (isset($_GET['id'])) {
    ?>
    <h2>Delete Quote</h2>
    <div class="container">
        <p>Are you sure you want to delete this quote?</p>
        <?php echo '<p>' . $row['text'] . '</p>'; ?>
        <?php echo '<b><i>' . $row['author'] . '</b></i>'; ?>
        <br>
        <form method="POST">
            <input class="FileButton" type="submit" value="Delete this Entry!" name="submit">
        </form>
    </div>
    <?php
}
if (isset($_GET['success'])) {
    if ($_GET['success'] == "deleted") {
        echo '<p class="success">The quote has been deleted!</p>';
    }
}
if (isset($_GET['error'])) {
    if ($_GET['error'] == "notdeleted") {
        echo '<p class="error">Quote not deleted!</p>';
    }
}
?>

<?php
include("templates/footer.php");
// Include the footer
?>