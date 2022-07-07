<?php
  include_once 'header.php';
  include 'includes/dbh.inc.php';

  if ($_SERVER["REQUEST_METHOD"] == "GET") { 
    $id = filter_input(INPUT_GET, 'id'); 

    if (empty($id)){ 
      header("location: ../game.php?id=".$id."&error=invalidrequest");
      exit(); 
    }     
  } 
  else{ 
    header("location: ../game.php?id=".$id."&error=invalidrequest");
    exit(); 
  }
?>

<div id="bot">
  <div id="body">
    <!-- Mensagens introduzidas aqui -->

    <?php
      $sql = "SELECT * FROM content WHERE creation_id='$id' AND contentType=1";
      $result = mysqli_query($conn, $sql);
      $inicio = mysqli_fetch_row($result);
    ?>
    <div class="parent" id="Start">
      <div class="chat-bubble-container">
        <div class="chat-bubble msg-bot">
            <div class="options">
              <button onclick="document.getElementById('Start').style.display='none'" id="#send" data-next="<?= $inicio[0] ?>" style="margin:0;">Começar</button>
            </div>
        </div>
      </div>
      <div class="chat-bubble-container action">
        <div class="chat-bubble msg-self"></div>
      </div>
    </div>
    <?php   
    $sql = "SELECT * FROM content WHERE creation_id='$id' ORDER BY contentType ASC"; 

    if (!$result = mysqli_query($conn, $sql)) { 
      echo mysqli_error($conn);
      mysqli_close($conn); 
    } else { 
      while ($row = mysqli_fetch_assoc($result)){
        echo  '<div class="parent" data-value="'.$row["id"].'" data-type="'.$row["contentType"].'">
                <div class="chat-bubble-container">
                  <div class="chat-bubble msg-bot">
                    <h2 class="part">'.$row["part"].'</h2>
                    <div class="story" readonly>'.$row["story"].'</div>
                      <div class="options">
                        <button id="#send" data-next="'.$row["nextA"].'">'.$row["choiceA"].'</button>
                        <button id="#send" data-next="'.$row["nextB"].'">'.$row["choiceB"].'</button>
                        <button id="#send" data-next="'.$row["nextC"].'">'.$row["choiceC"].'</button>
                        <button id="#send" data-next="'.$row["nextD"].'">'.$row["choiceD"].'</button>
                      </div>
                  </div>
                </div>
                <div class="chat-bubble-container action">
                  <div class="chat-bubble msg-self"></div>
                </div>
              </div>';
      }
    mysqli_free_result($result);
    mysqli_close($conn); 
    }
    ?>
  </div>
  <div class="talk">
    <select id='voiceList'></select>
    <input id="voiceBtn" type="button" value="Pausar" data-is-paused="false">
  </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="js/game.js"></script> 