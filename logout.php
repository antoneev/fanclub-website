<?php
//Include the header
include("templates/header.php");
session_unset();
session_destroy();
header("refresh: 1, logout.php");
?>


<h1>Antone Evans</h1>
<p>You are now logged out.</p>
<p>Thank you for using this site. Have a good day.</p>

<?php
//Include the footer
include("templates/footer.php");
?>
