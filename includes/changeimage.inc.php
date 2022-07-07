<?php
if(isset($_FILES["image"]["name"])){
  $imageName = $_FILES["image"]["name"];
  $imageSize = $_FILES["image"]["size"];
  $tmpName = $_FILES["image"]["tmp_name"];
  $table = $_POST["table"];
  $column = $_POST["column"];
  $name = $_POST["name"];
  $id = $_POST["id"];
  $page = $_POST["page"];

  require_once 'dbh.inc.php';
  require_once 'functions.inc.php';

  $variables = array($table, $column, $name, $id);
  if (emptyInput($variables) !== false) {
    header("location: ".$page."error=emptyhiddenvalues");
    exit();
  }
  if (imageExt($imageName) !== false) {
    header("location: ".$page."error.=invalidext");
    exit();
  }
  if (imageSize($imageSize) !== false){
    header("location: ".$page."error=imagetoolarge");
    exit();
  }

  changeImage($conn, $imageName, $tmpName, $table, $column, $name, $id, $page);
    
}else{
  header("location: ../settings.php");
  exit();
}