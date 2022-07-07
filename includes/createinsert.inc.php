<?php

if (isset($_POST["submit"])) {      
  $content_id = $_POST["content_id"];
  $next = $_POST["next"];
  $part = $_POST["part"];
  $story = $_POST["story"];
  $choiceA = $_POST["choiceA"];~
  $nextA = $_POST["nextA"];
  $choiceB = $_POST["choiceB"];
  $nextB = $_POST["nextB"];
  $choiceC = $_POST["choiceC"];
  $nextC = $_POST["nextC"];
  $choiceD = $_POST["choiceD"];
  $nextD = $_POST["nextD"];
  $type = $_POST["type"];

  require_once 'dbh.inc.php';
  require_once 'functions.inc.php';
  
  $variables = array($type);
  if (emptyInput($variables) !== false) {
    header("location: ../createinsertform.php?error=emptyinput");
    exit();
  }

  createContent($conn, $part, $story, $choiceA, $nextA, $choiceB, $nextB, $choiceC, $nextC, $choiceD, $nextD, $type, $content_id, $next);
  
}else{
  header("location: ../create.php");
  exit();
}

?>