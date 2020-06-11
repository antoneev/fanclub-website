<?php

//Include the header
include("templates/header.php");
?>


<?php

if (isset($_SESSION['loggedin'])) {
    echo'
    <h2>Add Books</h2>
<div class="container">
    <form action="books.php" method="POST">
        <div class="row">
            <div class="col-25">
                <label for="title">Book Title: </label>
            </div>
            <div class="col-75">
                <input type="text" name="title" required="">
            </div>
        </div>
        <div class="row">
            <div class="col-25">
                <label for="author">Book Author:</label>
            </div>
            <div class="col-75">
            <input type="text" name="author" required="">
            </div>
        </div>
        <div class="row">
            <input class="BookContactButton" type="submit" value="Add Book" name="submit">
        </div>
    </form>

    <h2>My Books</h2>

    ';
} else {
    echo'
     <h2>Example Books</h2>
<div class="container">
    <ul style="list-style-type:disc;">
        <li>The Catcher in the Rye</li>
        <li>Nine Stories</li>
        <li>Franny and Zooey</li>
        <li>Raise High the Roof Beam, Carpenters and Seymour An Introduction</li>
    </ul>  
</div>
    ';
}
?>

<?php

if (isset($_SESSION['loggedin'])) {
    $username = $_SESSION['username'];
    $row = 1;
    if (($handle = fopen('../users/' . $username . '/books.csv', "r")) !== FALSE) {
        while (($data = fgetcsv($handle, 1000, "|")) !== FALSE) {
            $num = count($data);
            $row++;
            echo '<li>';
            for ($c = 0; $c < $num; $c++) {
                if ($c == 1) {
                    echo "by ";
                }
                echo $data[$c] . "\n";
            }
            echo '<br>';
        }
        fclose($handle);
    }
}
?>


<?php

include("templates/footer.php");
// Include the footer
?>

<?php

if (isset($_POST['submit'])) {
    $title = $_POST['title'];
    $author = $_POST['author'];

    $list = array(
        array($title, $author),
    );

    $fp = fopen('../users/' . $username . '/books.csv', 'a');

    foreach ($list as $fields) {
        fputcsv($fp, $fields, "|");
    }

    fclose($fp);
    header("Location: books.php");
}
?> 