<?php
  include_once 'header.php';
  include_once 'includes/dbh.inc.php';

  $creation_id = $_SESSION["creationid"];
  $user_id = $_SESSION["userid"];
  $sql = "SELECT * FROM creations WHERE creator_id='$user_id' AND id='$creation_id'";

  if (!$result = mysqli_query($conn, $sql)) { 
    echo mysqli_error($conn);
    mysqli_close($conn);
  } else {
    while ($row = mysqli_fetch_assoc($result)){    
?>

  <div class="form">
    <div class="container" style="max-width: 600px;">
      <!-- FORM -->
        <h1 class="form_title">Editar Jogo</h1>

      <form id="editImageSmall" action="includes/changeimage.inc.php" enctype="multipart/form-data" method="post">
        <label for="upload-image-small" class="form_image-container">
            <img src="img/<?=$row['imageSmall']?>" alt="" class="form_img" style="width: 140px; height: 140px;"><i id="icon "class="fa fa-image"></i>
        </label>
        <input type="hidden" name="table" value="creations">
        <input type="hidden" name="column" value="imageSmall">
        <input type="hidden" name="name" value="<?=$row['title']?>">
        <input type="hidden" name="id" value="<?=$row['id']?>">
        <input type="hidden" name="page" value="../createsettings.php?">
        <input type="file" name="image" id="upload-image-small" accept=".jpg, .jpeg, .png"/>
      </form>
      <script>
        document.getElementById("upload-image-small").onchange = function(){
          document.getElementById("editImageSmall").submit();
        };
      </script>

      <form id="editImageBig" action="includes/changeimage.inc.php" enctype="multipart/form-data" method="post">
        <label for="upload-image-big" class="form_image-container">
            <img src="img/<?=$row['imageBig']?>" alt="" class="form_img" style="width:100%; max-width:640px; max-height:360px;"><i id="icon "class="fa fa-image"></i>
        </label>
        <input type="hidden" name="table" value="creations">
        <input type="hidden" name="column" value="imageBig">
        <input type="hidden" name="name" value="<?=$row['title']?>">
        <input type="hidden" name="id" value="<?=$row['id']?>">
        <input type="hidden" name="page" value="../createsettings.php?">
        <input type="file" name="image" id="upload-image-big" accept=".jpg, .jpeg, .png"/>
      </form>
      <script>
          document.getElementById("upload-image-big").onchange = function(){
            document.getElementById("editImageBig").submit();
          };
        </script>

      <form id="editGame" action="includes/createsettings.inc.php" method="post">
        <input class="form_input" type="text" name="title" placeholder="Título" value="<?=$row['title']?>">
        <textarea class="form_textarea" name="description" placeholder="Descrição"><?=$row['descriptions']?></textarea>
        <div id="alert" class="form_message"></div>
        <button class="form_button" type="submit" name="submit">Editar</button>
      </form>
    </div>
  </div>

<?php
    }
  mysqli_free_result($result);
  mysqli_close($conn); 
  }
  include_once 'footer.php';
?>