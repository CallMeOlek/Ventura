<?php
  $creation_id = $_POST["id"];
  $type = $_POST["like"];

  require_once 'dbh.inc.php';
  require_once 'functions.inc.php';
  
  if (checkLike($conn, $creation_id, $type) !== false) {
    unlike($conn, $creation_id, $type);
    exit();
  }

  like($conn, $creation_id, $type);
?>