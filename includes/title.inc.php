<?php

if (isset($_POST["submit"])) {
  $title = $_POST["title"];

  require_once 'dbh.inc.php';
  require_once 'functions.inc.php';

  $variables = array($title);
  if (emptyInput($variables) !== false) {
    header("location: ../title.php?error=emptyinput");
    exit();
  }
  if (invalidTitle($title) !== false) {
    header("location: ../title.php?error=invalidtitle");
    exit();
  }

  createCreation($conn, $title);
  
}else{
  header("location: ../title.php");
  exit();
}

?>