<?php
  include_once 'header.php';
  include 'includes/dbh.inc.php';
  include 'includes/functions.inc.php';

  $user_id = $_SESSION["userid"];
  $sql = "SELECT * FROM users WHERE id='$user_id'";

  if (!$result = mysqli_query($conn, $sql)) { 
    echo mysqli_error($conn);
    mysqli_close($conn);
  } else { 
    while ($row = mysqli_fetch_assoc($result)){    
?>
  <!-- PROFILE -->
  <div class="main profile">
    <div class="inner_profile">

      <!-- IMAGE -->
      <div class="img_container">
        <img src="img/<?=$row['usersPhoto']?>" alt="" style="width: 128px; height: 128px;">
      </div>

      <!-- PROFILE INFO -->
      <div class="container">
        <div class="info_up">
          <li><h2><?=$row['usersName']?></h2></li>
          <li><p>@<?=$row['usersUid']?></p></li>
        </div>
        <div class="info_down"></div>
      </div>
      <a href="settings.php"><i class="fa fa-gear"></i></a>
    </div>

      <?php
        }
        mysqli_free_result($result);
      }
      ?>

      <!-- TABS -->
      <div class="tabs_bar">
        <button class="tab_button" data-for-tab="1">Favoritos</button>
        <div style="border-left:1px solid var(--color-background-light);height:auto"></div>
        <button class="tab_button" data-for-tab="2">Minhas Criações</button>
      </div>

      <!-- GRID -->
      <div class="page" data-tab="1">
        <?php 
          $sql = "SELECT * FROM creations WHERE id IN (SELECT creation_id FROM favorites WHERE users_id='$user_id')"; 

          if (!$result = mysqli_query($conn, $sql)) { 
            echo mysqli_error($conn);
            mysqli_close($conn);
          } else { 
            while ($row = mysqli_fetch_assoc($result)){    
              echo  '<a href="gamepage.php?id='.$row["id"].'">
                      <div class="grid_item">
                        <img src="img/'.$row['imageSmall'].'">
                        <div class="info">
                          <p class="name_game">'.$row["title"].'</p>
                          <div class="statistics">
                            <p>'.likePercent($conn, $row["id"]).'%<i class="fa fa-thumbs-up"></i></p>
                            <p style="display: none;">2k<i class="fa fa-eye"></i></p>
                          </div>
                        </div>
                      </div>
                    </a>';
            } 
            mysqli_free_result($result);
          }
        ?>
      </div>

      <div class="page" data-tab="2">
        <?php 
          $sql = "SELECT * FROM creations WHERE creator_id='$user_id'"; 

          if (!$result = mysqli_query($conn, $sql)) { 
            echo mysqli_error($conn);
            mysqli_close($conn);
          } else { 
            $i=1;
            while ($row2 = mysqli_fetch_assoc($result)){    
              echo  '<div class="grid_item">
                      <img src="img/'.$row2['imageSmall'].'">
                      <div class="info">
                        <p class="name_game">'.$row2["title"].'</p>
                        <div class="statistics">
                          <p>'.likePercent($conn, $row2["id"]).'%<i class="fa fa-thumbs-up"></i></p>
                          <p style="display: none;">2k<i class="fa fa-eye"></i></p>
                        </div>
                        <hr></hr>
                        <div class="grid_settings">
                          <a href="gamepage.php?id='.$row2['id'].'" class="setting_btn">Ver</a>
                          <a onclick="localStorage.setItem(`content`, 0);" href="create.php?id='.$row2['id'].'&operacao=editar" class="setting_btn">Editar</a>
                          <a onclick="document.getElementById(`'.$i.'`).style.display=`block`")" class="setting_btn">Apagar</a>
                        </div>
                      </div>
                    </div>
                    
                    <div id="'.$i.'" class="modal">
                      <div class="form">
                        <span onclick="document.getElementById(`'.$i.'`).style.display=`none`" class="close" title="Fechar Janela">×</span>
                        <div class="container" style="max-width:400px;">
                          <h2 class="form_title">Apagar Jogo</h2>
                          <p class="form_text">Tens certeza que queres apagar este jogo?</p>
                          <h3 class="form_input">'.$row2["title"].'</h3>

                          <div class="row">
                            <a class="modal_link" href="includes/createdelete.inc.php?id='.$row2['id'].'&operacao=apagar&table=creations"><button type="button" onclick="document.getElementById(`'.$i.'`).style.display=`none`" class="form_button delete">Apagar</button></a>
                            <a class="modal_link"><button type="button" onclick="document.getElementById(`'.$i.'`).style.display=`none`" class="form_button">Cancelar</button></a>
                          </div>
                        </div>
                      </div>
                    </div>';
              $i++;
            }
            mysqli_free_result($result);
            mysqli_close($conn);
          }
        ?>
      </div>

    </div>
  </div>

<?php
  include_once 'footer.php';
?>