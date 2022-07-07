<?php

if (isset($_POST["submit"])) {
  $id = $_POST["id"];
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
    header("location: ../createeditform.php?id=".$id."&operacao=editar&error=emptyinput");
    exit();
  }

  editContent($conn, $id, $part, $story, $choiceA, $nextA, $choiceB, $nextB, $choiceC, $nextC, $choiceD, $nextD, $type);
  
}else{
  header("location: ../create.php");
  exit();
}

?>