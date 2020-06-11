<div class="footer">
    <hr>
    <p>Design uses <a href="#">Concise CSS Framework</a></p>
    <?php
    //$cstTimezone = new DateTimeZone('CST');
    //echo date("h:ia",$c);

    date_default_timezone_set('America/Chicago');
    $date = date('h:i a l F j', time());
    echo $date;
    ?>
</div>
</body>
</html>