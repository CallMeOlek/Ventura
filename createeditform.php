<?php 
  include_once "header.php";
  include "includes/dbh.inc.php";

  if ($_SERVER["REQUEST_METHOD"] == "GET") { 
    $id = filter_input(INPUT_GET, 'id'); 
    $operacao = filter_input(INPUT_GET, 'operacao'); 

    if (empty($id) || $operacao!="editar"){ 
      header("location: ../createeditform.php?id=".$id."&operacao=editar&error=invalidrequest");
      exit(); 
    }     
  } 
  else{ 
    header("location: ../createeditform.php?id=".$id."&operacao=editar&error=invalidrequest");
    exit(); 
  } 
  $creation_id = $_SESSION["creationid"];
  $sql = "SELECT * FROM content WHERE id = '$id'"; 

  if (!$result = mysqli_query($conn, $sql)) { 
    echo mysqli_error($conn);
    mysqli_close($conn);
  } else {
   $row = mysqli_fetch_assoc($result);
?> 
  
  <div class="form">
    <div class="container">
      <!-- FORM -->
      <form id="create" action="includes/createedit.inc.php" method="post" autocomplete="off">
        <h1 class="form_title">Editar Secção</h1>

        <!-- INPUTS -->
        <input class="form_input" type="text" name="id" placeholder="ID" value="<?=$row['id']?>" style="display:none;">
        <input class="form_input" type="text" name="part" placeholder="Título" value="<?=$row['part']?>">
        <textarea id="story" class="form_input form_textarea" type="text" name="story" placeholder="História"><?=$row['story']?></textarea>
        <div class="row">
          <input class="form_input" type="text" name="choiceA" placeholder="Escolha A" value="<?=$row['choiceA']?>">
          <div class="custom-select" style="width:50%;">
            <select name="nextA">
              <?php 
                $sql = "SELECT * FROM content WHERE creation_id='$creation_id' AND id!='$id' ORDER BY part"; 

                if (!$result = mysqli_query($conn, $sql)) { 
                  echo mysqli_error($conn);
                  mysqli_close($conn);
                } else {
                  if ($row["nextA"] == 0){
                    echo '<option value="0">Próximo</option>';
                  }
                  foreach($result as $row2){
                    if ($row["nextA"] == $row2["id"]){
                      echo '<option value="'.$row["nextA"].'">'.$row2["part"].'</option>';
                    }
                  }
                  echo '<option value="0">Nenhum</option>';
                  foreach($result as $row2){
                    if ($row["nextA"] !== $row2["id"]){
                      echo '<option value="'.$row2["id"].'">'.$row2["part"].'</option>';
                    }
                  }
                
              ?>
            </select>
          </div>
        </div>
        <div class="row">
          <input class="form_input" type="text" name="choiceB" placeholder="Escolha B" value="<?=$row['choiceB']?>">
          <div class="custom-select" style="width:50%;">
            <select name="nextB">
              <?php  
                if ($row["nextB"] == 0){
                  echo '<option value="0">Próximo</option>';
                }else{
                  foreach($result as $row2){
                    if ($row["nextB"] == $row2["id"]){
                      echo '<option value="'.$row["nextB"].'">'.$row2["part"].'</option>';
                    }
                  }
                }
                echo '<option value="0">Nenhum</option>';
                foreach($result as $row2){
                  if ($row["nextB"] !== $row2["id"]){
                    echo '<option value="'.$row2["id"].'">'.$row2["part"].'</option>';
                  }
                }
              ?>
            </select>
          </div>
        </div>
        <div class="row">
          <input class="form_input" type="text" name="choiceC" placeholder="Escolha C" value="<?=$row['choiceC']?>">
          <div class="custom-select" style="width:50%;">
            <select name="nextC">
              <?php 
                if ($row["nextC"] == 0){
                  echo '<option value="0">Próximo</option>';
                }
                foreach($result as $row2){
                  if ($row["nextC"] == $row2["id"]){
                    echo '<option value="'.$row["nextC"].'">'.$row2["part"].'</option>';
                  }
                }
                echo '<option value="0">Nenhum</option>';
                foreach($result as $row2){
                  if ($row["nextC"] !== $row2["id"]){
                    echo '<option value="'.$row2["id"].'">'.$row2["part"].'</option>';
                  }
                }
              ?>
            </select>
          </div>
        </div>
        <div class="row">
          <input class="form_input" type="text" name="choiceD" placeholder="Escolha D" value="<?=$row['choiceD']?>">
          <div class="custom-select" style="width:50%;">
            <select name="nextD">
              <?php 
                  if ($row["nextD"] == 0){
                    echo '<option value="0">Próximo</option>';
                  }
                  foreach($result as $row2){
                    if ($row["nextD"] == $row2["id"]){
                      echo '<option value="'.$row["nextD"].'">'.$row2["part"].'</option>';
                    }
                  }
                  echo '<option value="0">Nenhum</option>';
                  foreach($result as $row2){
                    if ($row["nextD"] !== $row2["id"]){
                      echo '<option value="'.$row2["id"].'">'.$row2["part"].'</option>';
                    }
                  }
              ?>
            </select>
          </div>
        </div>
        
        <div class="row">
          <?php $radio = $row['contentType']; ?>
        
          <label class="checkbox">Início
            <input type="radio" name="type" value="1" <?php echo ($radio == '1') ?  "checked" : "" ;  ?>>
            <span class="checkmark"></span>
          </label>
          <label class="checkbox">Meio
            <input type="radio" name="type" value="2" <?php echo ($radio == '2') ?  "checked" : "" ;  ?>>
            <span class="checkmark"></span>
          </label>
          <label class="checkbox">Final
            <input type="radio" name="type" value="3" <?php echo ($radio == '3') ?  "checked" : "" ;  ?>>
            <span class="checkmark"></span>
          </label>

        </div>
        <div id="alert" class="form_message"></div>
        <button class="form_button" type="submit" name="submit">Editar</button>
    
      </form>
    </div>
  </div>

<?php 
  mysqli_free_result($result);
  mysqli_close($conn);  
  } 
}

  include_once "footer.php";
?>