<?php
    /* Database connection start */
    $servername = "localhost";
    $username = "root";
    $password = "Boon2021";
    $dbname = "boonweb";
    $conn = mysqli_connect($servername, $username, $password, $dbname);
    if (mysqli_connect_errno()) {
        printf("Connect failed: %sn", mysqli_connect_error());
        exit();
    }
?>