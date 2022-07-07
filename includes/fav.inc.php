<?php
  $creation_id = $_POST["id"];

  require_once 'dbh.inc.php';
  require_once 'functions.inc.php';
  
  if (checkFav($conn, $creation_id) !== false) {
    unFav($conn, $creation_id);
    exit();
  }

  Fav($conn, $creation_id);
?>