<?php

if ($_SERVER["REQUEST_METHOD"] == "GET") { 
  $id = filter_input(INPUT_GET, 'id'); 
  $operacao = filter_input(INPUT_GET, 'operacao'); 
  $table = filter_input(INPUT_GET, 'table'); 

  require_once 'dbh.inc.php';
  require_once 'functions.inc.php';
  
  if (emptyOperation($id, $operacao, $table) !== false) {
    header("location: ../index.php?invalidrequest");
    exit();
  }

  deleteCreation($conn, $id, $table);

} 
else{ 
  header("location: ../index.php");
  exit(); 
}
?> 