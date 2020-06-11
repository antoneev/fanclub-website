<?php
//Include the header
include("templates/header.php");
if (!isset($_SESSION['loggedin'])) {
    header("Location: quotes.php");
}
?>

<h2>Add Quote</h2>
<div class="container">
    <form action="add_quote.php" method="POST">
        <?php
        if (isset($_GET['error'])) {
            if ($_GET['error'] == "quotenotenter") {
                echo '<p class="error">Quote not entered!</p>';
            }
        }
        if (isset($_GET['success'])) {
            if ($_GET['success'] == "quoteentered") {
                echo '<p class="success">Quote has been successfully added!</p>';
            }
        }
        ?>
        <div class="row">
            <div class="col-25">
                <label for="author">Author: </label>
            </div>
            <div class="col-75">
                <input type="text" name="author" required="">
            </div>
        </div>
        <div class="row">
            <div class="col-25">
                <label for="quote">Quote:</label>
            </div>
            <div class="col-75">
                <textarea name="quote" required="" style="height:200px"></textarea>
            </div>
            <div class="col-75">
                <input type="checkbox" name="fav" value="Y">
                <label for="fav"> Check to add as a favorite</label><br>
            </div>
        </div>
        <div class="row">
            <input class="BookContactButton" type="submit" value="Submit Quote!" name="submit">
        </div>
    </form>
</div>


<?php
include("templates/footer.php");
// Include the footer
?>

<?php
if (isset($_POST['submit'])) {
    if (isset($_POST['fav'])) {
        $checkbox = $_POST['fav'];
    } else {
        $checkbox = "N";
    }

    $author = $_POST['author'];
    $quote = $_POST['quote'];
    $date = date("Y:m:d H:i:s");

    $sql = "INSERT INTO quotes (text, author, favorite, date_entered) VALUES ('$quote', '$author', '$checkbox', '$date')";

    if (mysqli_query($dbc, $sql)) {
        header("Location: add_quote.php?success=quoteentered");
        exit();
    } else {
        header("Location: add_quote.php?error=quotenotenter");
        exit();
    }

    mysqli_close($dbc);
}
?>