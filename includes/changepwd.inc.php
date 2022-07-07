<?php

if (isset($_POST["submit"])) {
    
  $oldPwd = $_POST["oldpwd"];
  $newPwd = $_POST["newpwd"];
  $newPwdRepeat = $_POST["newpwdrepeat"];

  require_once 'dbh.inc.php';
  require_once 'functions.inc.php';

  $variables = array($oldPwd, $newPwd, $newPwdRepeat);
  if (emptyInput($variables) !== false) {
    header("location: ../settings.php?tab=pwd&error=emptyinput");
    exit();
  }
  if (pwdMatch($newPwd, $newPwdRepeat) !== false) {
    header("location: ../settings.php?tab=pwd&error=passwordsdontmatch");
    exit();
  }

  changePwd($conn, $oldPwd, $newPwd);

}else{
  header("location: ../settings.php?tab=pwd");
  exit();
}

?>