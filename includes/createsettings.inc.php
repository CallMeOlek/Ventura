<?php

if (isset($_POST["submit"])) {
  $title = $_POST["title"];
  $description = $_POST["description"];

  require_once 'dbh.inc.php';
  require_once 'functions.inc.php';

  $variables = array($title);
  if (emptyInput($variables) !== false) {
    header("location: ../createsettings.php?error=emptyinput");
    exit();
  }
  if (invalidTitle($title) !== false) {
    header("location: ../createsettings.php?error=invalidtitle");
    exit();
  }

  editGame($conn, $title, $description);
  
}else{
  header("location: ../title.php");
  exit();
}

?>