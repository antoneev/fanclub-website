<?php
//Include the header
include("templates/header.php");
if (!isset($_SESSION['loggedin'])) {
    header("Location: index.php");
}
?>

<div class="container">
    <form action="upload.php" method="post" enctype="multipart/form-data">
        <?php
        if (isset($_GET['error'])) {
            if ($_GET['error'] == "invalidfile") {
                echo '<p class="error">Error uploading file</p>';
            }
            if ($_GET['error'] == "invalidtype") {
                echo '<p class="error">ERROR! Your site must have a file extension of pdf,doc,docx, or txt file!</p>';
            }
        } else if (isset($_GET['success'])) {
            if ($_GET['success'] == "fileupload") {
                echo '<p class="success">Your file was uploaded successfully!</p>';
            }
        }
        ?>
        <p>Upload a story file please note your file must have a file extension of pdf,doc,docx, or txt</p>
        <input type="file" name="file">
        <br/>
        <input class="FileButton" type="submit" value="Upload This File" name="submit">
    </form>
</div>

<?php
//Include the footer
include("templates/footer.php");
?>

<?php
$username = $_SESSION['username'];
if (!empty($_FILES['file'])) {
    $path = '../users/' . $username . '/';
    $path = $path . basename($_FILES['file']['name']);

    $allowed = array('pdf', 'doc', 'docx', 'txt');
    $filename = $_FILES['file']['name'];
    $ext = pathinfo($filename, PATHINFO_EXTENSION);

    if (!in_array($ext, $allowed)) {
        header("Location: upload.php?error=invalidtype");
        exit();
    } else {
        if (move_uploaded_file($_FILES['file']['tmp_name'], $path)) {
            header("Location: upload.php?success=fileupload");
            exit();
        } else {
            header("Location: upload.php?error=invalidfile");
            exit();
        }
    }
}
?>