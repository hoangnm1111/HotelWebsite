<?php
    $hostName = "localhost";
    $dbUser = "root";
    $dbPassword = "";
    $dbName = "hotelwebsite";
    $conn = mysqli_connect($hostName, $dbUser, $dbPassword, $dbName);

    if(!$conn) 
    {
        die("Không thể kết nối tới database".mysqli_connect_error());
    }
?>