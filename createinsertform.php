<?php
  include_once 'header.php';
  include 'includes/dbh.inc.php';

  $content_id = filter_input(INPUT_GET, 'id'); 
  $next = filter_input(INPUT_GET, 'next');

  if ($next !== null && $content_id !== null){
    $sql = "SELECT choice$next FROM content WHERE id='$content_id'";
    if($result = mysqli_query($conn, $sql)){
      $title = mysqli_fetch_assoc($result);
    }
  }
?>

  <div class="form">
    <div class="container">
      <!-- FORM -->
      <form id="create" action="includes/createinsert.inc.php" method="post" autocomplete="off">
        <h1 class="form_title">Inserir Nova Secção</h1>
        <input type="hidden" name="content_id" value="<?=$content_id?>">
        <input type="hidden" name="next" value="<?=$next?>">

        <!-- INPUTS -->
        <input class="form_input" type="text" name="part" placeholder="Título" value=
        "<?php  
          if (isset($title)){
            echo $title["choice".$next];
          } else{
            echo "";
          }
        ?>">
        <textarea class="form_input form_textarea" type="text" name="story" placeholder="História"></textarea>
        <div class="row">
          <input class="form_input" type="text" name="choiceA" placeholder="Escolha A">
          <div class="custom-select" style="width:50%;">
            <select name="nextA">
              <option value="0">Próximo</option>
              <option value="0">Nenhum</option>
              <?php 
                $creation_id = $_SESSION["creationid"];
                $sql = "SELECT * FROM content WHERE creation_id='$creation_id' ORDER BY part"; 

                if (!$result = mysqli_query($conn, $sql)) { 
                  echo mysqli_error($conn);
                  mysqli_close($conn);
                } else {
                  foreach($result as $row){
                    echo  '<option value="'.$row['id'].'">'.$row['part'].'</option>';
                  }
              ?>
            </select>
          </div>
        </div>
        <div class="row">
          <input class="form_input" type="text" name="choiceB" placeholder="Escolha B">
          <div class="custom-select" style="width:50%;">
            <select name="nextB">
              <option value="0">Próximo</option>
              <option value="0">Nenhum</option>
              <?php 
                foreach($result as $row){
                  echo  '<option value="'.$row['id'].'">'.$row['part'].'</option>';
                }
              ?>
            </select>
          </div>
        </div>
        <div class="row">
          <input class="form_input" type="text" name="choiceC" placeholder="Escolha C">
          <div class="custom-select" style="width:50%;">
            <select name="nextC">
              <option value="0">Próximo</option>
              <option value="0">Nenhum</option>
              <?php 
                foreach($result as $row){
                  echo  '<option value="'.$row['id'].'">'.$row['part'].'</option>';
                }
              ?>
            </select>
          </div>
        </div>
        <div class="row">
          <input class="form_input" type="text" name="choiceD" placeholder="Escolha D">
          <div class="custom-select" style="width:50%;">
            <select name="nextD">
              <option value="0">Próximo</option>
              <option value="0">Nenhum</option>
              <?php 
                  foreach($result as $row){
                    echo  '<option value="'.$row['id'].'">'.$row['part'].'</option>';
                  }
                mysqli_free_result($result);
                mysqli_close($conn); 
                }
              ?>
            </select>
          </div>
        </div>
        <div class="row">
          <label class="checkbox">Início
            <input type="radio" name="type" value="1">
            <span class="checkmark"></span>
          </label>
          <label class="checkbox">Meio
            <input type="radio" name="type" value="2" checked>
            <span class="checkmark"></span>
          </label>
          <label class="checkbox">Final
            <input type="radio" name="type" value="3">
            <span class="checkmark"></span>
          </label>
        </div>
        <div id="alert" class="form_message"></div>
        <button class="form_button" type="submit" name="submit">Inserir</button>
    
      </form>
    </div>
  </div>

<?php
  include_once 'footer.php';
?>