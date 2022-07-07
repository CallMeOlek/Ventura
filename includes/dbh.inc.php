<?php

$serverName = "localhost";
$dBUserName = "root";
$dBPassword = "root";
$dBName = "ventura";

$conn = mysqli_connect($serverName, $dBUserName, $dBPassword, $dBName);
$conn->set_charset("utf8");

if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

?>