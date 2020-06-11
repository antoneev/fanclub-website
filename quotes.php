<?php
//Include the header
include("templates/header.php");
?>

<h2>Quotes</h2>
<div class="container">
    <?php
    if (isset($_SESSION['loggedin'])) {
        echo '<h3><a href="add_quote.php">Add New Quote</a></h3>';
    }
    $sql = "SELECT * FROM quotes ORDER BY id desc;";
    $result = $dbc->query($sql);

    if ($result->num_rows > 0) {
        // output data of each row
        while ($row = $result->fetch_assoc()) {
            echo '<div class="v1">' . $row["text"];
            if ($row["favorite"] == "Y") {
                echo '<b style="color:red;">  Favorite! </b></div>';
            }
            echo "<p><b><i>" . $row["author"] . "</b></i></p>";
            if (isset($_SESSION['loggedin'])) {
                echo '<p><a href="update_quote.php?id=' . $row['id'] . '" style="color:#3C8DC3">Edit</a> <a href="delete_quote.php?id=' . $row['id'] . '" style="color:#3C8DC3">Delete</a></p>';
            }
            echo "<hr>";
        }
    } else {
        echo "0 results";
    }
    $dbc->close();
    ?>
</div>


<?php
//Include the footer
include("templates/footer.php");
?>