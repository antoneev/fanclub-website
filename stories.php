<?php
//Include the header
include("templates/header.php");
if (!isset($_SESSION['loggedin'])) {
    header("Location: index.php");
}
?>

<h2>Stories Uploaded</h2>

<?php
$username = $_SESSION['username'];
$dir = '../users/' . $username . '/';

$files1 = scandir($dir);

echo '<table><tr>';
echo '<th>Name</th>';
echo '<th>Last Modified</th></tr><tr>';

foreach ($files1 as $file) {
    $dir = '../users/' . $username . '/' . $file;
    if ($file == "..") {
        continue;
    } elseif ($file == ".") {
        continue;
    } elseif ($file == "books.csv") {
        continue;
    } else {
        $dir = preg_replace('/\?v=[\d]+$/', '', $dir);
        date_default_timezone_set('America/Chicago');
        $mod_date = date("m/d/Y H:i:s a", filemtime($dir));
        //echo "<br> $file last modified on ". $mod_date;
        echo"<th> $file </th>";
        echo "<th> $mod_date </th>";
        echo "<br/>";
        echo '</tr>';
    }
}
echo '</table>';
?>

<?php
//Include the footer
include("templates/footer.php");
?>
