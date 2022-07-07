<?php
  include_once 'header.php';
  include_once 'includes/dbh.inc.php';
  
  $user_id = $_SESSION["userid"];
  $sql = "SELECT * FROM users WHERE id='$user_id'";

  if (!$result = mysqli_query($conn, $sql)) { 
    echo mysqli_error($conn);
    mysqli_close($conn);
  } else { 
    $i=1;
    while ($row = mysqli_fetch_assoc($result)){    
?>

  <div class="settings">
    <div class="tabs_bar">
        <button data-for-tab="1" class="tab_button">Editar Perfil</button>
        <button data-for-tab="2" class="tab_button">Mudar Palavra-Passe</button>
        <button data-for-tab="3" class="tab_button" style="display: none;">Linguagem</button>
        <button data-for-tab="4" class="tab_button" style="display: none;">Apagar Conta</button>
    </div>
    <div class="page" data-tab="1">
      <!-- PAGE CONTENT -->
      <div class="container">
        <!-- FORM -->
        <form id="editProfPic" action="includes/changeimage.inc.php" enctype="multipart/form-data" method="post">
          <label for="upload-photo" class="form_image-container">
              <img src="img/<?=$row['usersPhoto']?>" alt="" class="form_img" style="border-radius: 50%; width: 128px; height: 128px;"><i id="icon "class="fa fa-image"></i>
          </label>
          <input type="hidden" name="table" value="users">
          <input type="hidden" name="column" value="usersPhoto">
          <input type="hidden" name="name" value="<?=$row['usersUid']?>">
          <input type="hidden" name="id" value="<?=$row['id']?>">
          <input type="hidden" name="page" value="../settings.php?tab=profedit&">
          <input type="file" name="image" id="upload-photo" accept=".jpg, .jpeg, .png"/>
        </form>

        <script>
          document.getElementById("upload-photo").onchange = function(){
            document.getElementById("editProfPic").submit();
          };
        </script>
        
        <!-- FORM -->
        <form id="editProf" action="includes/editprof.inc.php" method="post">

          <!-- INPUTS -->
          <input class="form_input" type="text" name="name" placeholder="Nome" value="<?=$row['usersName']?>">
          <input class="form_input" type="email" name="email" placeholder="Email" value="<?=$row['usersEmail']?>">
          <div id="alert" class="form_message"></div>
          <button class="form_button" type="button" onclick="document.getElementById('editprof').style.display=`block`">Mudar</button>
          <div id="editprof" class="modal">
            <div class="form">
              <span onclick="document.getElementById('editprof').style.display=`none`" class="close" title="Fechar Janela">×</span>
              <div class="container" style="max-width:400px;">
                <p class="form_text">Por favor, introduza a sua palavra-passe.</p>
                <input class="form_input" type="password" name="pwd" placeholder="Palavra-Passe">

                <div class="row">
                  <button class="form_button" type="submit" name="submit" onclick="document.getElementById('editprof').style.display=`none`">Submeter</button>
                  <button type="button" onclick="document.getElementById('editprof').style.display=`none`" class="form_button">Cancelar</button>
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>

    <div class="page" data-tab="2">
      <!-- PAGE CONTENT -->
      <div class="container">
        
        <!-- FORM -->
        <form id="changePassword" action="includes/changepwd.inc.php" method="post">
          <h1 class="form_title">Mudar Palavra-Passe</h1>

          <!-- INPUTS -->
          <input class="form_input" type="password" name="oldpwd" placeholder="Palavra-passe antiga">
          <input class="form_input" type="password" name="newpwd" placeholder="Nova palavra-passe">
          <input class="form_input" type="password" name="newpwdrepeat" placeholder="Repetir nova palavra-passe">
          <div id="alert" class="form_message"></div>
          <button class="form_button" type="submit" name="submit">Mudar</button>
        </form>
      </div>
    </div>
    <div class="page" data-tab="3"></div>
    <div class="page" data-tab="4"></div>
      
  </div>

<?php
    }
    mysqli_free_result($result);
    mysqli_close($conn);
  }
  include_once 'footer.php';
?>