<?php

if (isset($_POST["submit"])) {
    
  $name = $_POST["name"];
  $email= $_POST["email"];
  $pwd= $_POST["pwd"];

  require_once 'dbh.inc.php';
  require_once 'functions.inc.php';

  $variables = array($pwd, $name, $email);
  if (emptyInput($variables) !== false) {
    header("location: ../settings.php?tab=profedit&error=emptyinput");
    exit();
  }

  editProf($conn, $name, $email, $pwd);

}else{
  header("location: ../settings.php?tab=profedit");
  exit();
}

?>