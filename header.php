<?php 
  session_start();
?>

<!DOCTYPE html>
<html lang="en" id="html">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
  <link rel="stylesheet" href="http://fonts.cdnfonts.com/css/gotham">
  <link rel="stylesheet" type="text/css" href="css/styles.css">
  <link rel="stylesheet" type="text/css" href="css/grid.css">
  <link rel="stylesheet" type="text/css" href="css/form.css">
  <link rel="stylesheet" type="text/css" href="css/profile.css">
  <link rel="stylesheet" type="text/css" href="css/settings.css">
  <link rel="stylesheet" type="text/css" href="css/create.css">
  <link rel="stylesheet" type="text/css" href="css/game.css">
  <link rel="stylesheet" type="text/css" href="css/gamepage.css">
  <title>Ventura</title>
</head>

<body>
  <div id="header" class="header">
    <div class="inner_header">

      <!-- LOGO -->
      <div class="logo_container">
        <a href="index.php"><h1>V<span>entura</span></h1></a>
      </div> 

      <!-- PESQUISA -->
      <div class="search_bar">
        <div class="inner_search" style="display:none;">
          <i class="fa fa-search"></i>
          <input type="text" name="search" placeholder="Pesquisa">
        </div>
      </div>

      <!-- NAVEGAÇÃO -->
      <div class="navigation">
        <?php
          if (isset($_SESSION["useruid"])) {
            echo '<a href="title.php"><li>Criar</li></a>';
            echo '<a href="profile.php"><li>' . $_SESSION["useruid"] . '</li></a>';
            echo '<a href="includes/logout.inc.php"><li>Sair</li></a>';
          }else{
            echo '<a href="signup.php"><li>Criar Conta</li></a>';
            echo '<a href="login.php"><li>Entrar</li></a>';
          }
        ?>
      </div>
    </div>
  </div>