<?php
  include_once 'header.php';
  include 'includes/dbh.inc.php';

  if ($_SERVER["REQUEST_METHOD"] == "GET") { 
    $id = filter_input(INPUT_GET, 'id'); 

    if (empty($id)){ 
      header("location: ../index.php?id=".$id."&error=invalidrequest");
      exit(); 
    }     
  } 
  else{ 
    header("location: ../index.php?id=".$id."&error=invalidrequest");
    exit(); 
  }

  $sql = "SELECT * FROM creations WHERE id='$id'";

  if (!$result = mysqli_query($conn, $sql)) { 
    echo mysqli_error($conn);
    mysqli_close($conn); 
  } else { 
      $game = mysqli_fetch_assoc($result);
      $creator_id = $game["creator_id"];
      $result = mysqli_query($conn, "SELECT usersUid FROM users WHERE id='$creator_id'");
      $creator = mysqli_fetch_assoc($result);
?>
  <!-- PROFILE -->
  <div class="main gamepage">
    <div class="inner_main">
      <div class="row">
        <div class="img-section"><img src="img/<?=$game['imageBig']?>" alt=""></div>
        <div class="info-section">
          <h1 class="title"><?=$game['title']?></h1>
          <p class="creator">de <b><?=$creator['usersUid']?></b></p>

          <div class="lower">
            <a class="play" href="game.php?id=<?=$id?>"><button class="form_button">Jogar</button></a>
            <div class="interact">
              <?php 
                // Guarda o número de likes e dislikes nuam váriavel
                $sql = "SELECT * FROM likes WHERE creation_id='$id' AND types=1";
                if ($result = mysqli_query($conn, $sql)){
                  $likes = mysqli_num_rows($result);
                }

                $sql = "SELECT * FROM likes WHERE creation_id='$id' AND types=2";
                if ($result = mysqli_query($conn, $sql)){
                  $dislikes = mysqli_num_rows($result);
                }

                // Verifica se o utiliziador está logado
                if (isset($_SESSION["useruid"])) : 
                  $user_id = $_SESSION["userid"];

                  // Busca os valores necessários para verificar se o utilizador deu like ou dislike
                  $sql = "SELECT * FROM likes WHERE creation_id='$id' AND users_id='$user_id'";
                  $result = mysqli_query($conn, $sql);
                  $row = mysqli_fetch_assoc($result);
                  $types = $row['types'];
                  

                  $stmt = mysqli_prepare($conn, "SELECT * FROM favorites WHERE users_id=? AND creation_id=?");
                  mysqli_stmt_bind_param($stmt, "ss", $user_id, $id);
                  mysqli_stmt_execute($stmt);
                  $fav = $stmt->fetch();
                  if ($fav) {
                    $fav = true;
                  } else {
                    $fav = false;
                  } 
                ?>
                <form id="favForm" action="includes/fav.inc.php" method="post" autocomplete="off">
                  <input type="hidden" name="id" value="<?=$id?>">
                  <label class="checkbox">
                    <input id="fav" type="checkbox" name="fav" <?php echo ($fav == true) ?  "checked" : "" ;  ?>>
                    <i class="fa fa-star"></i>
                    <p>Favorito</p>
                  </label>
                </form>
                <script>
                  document.getElementById("fav").onchange = function(){
                    document.getElementById("favForm").submit();
                  };
                </script>
                <form id="likeForm" action="includes/like.inc.php" method="post" autocomplete="off">
                  <input type="hidden" name="id" value="<?=$id?>">
                  <label class="checkbox">
                    <input id="like" type="checkbox" name="like" value="1" <?php echo ($types == '1') ?  "checked" : "" ;  ?>>
                    <i class="fa fa-thumbs-up"></i>
                    <p class="like_counter"><?=$likes?></p>
                  </label>
                  <label class="checkbox">
                    <input id="like" type="checkbox" name="like" value="2" <?php echo ($types == '2') ?  "checked" : "" ;  ?>>
                    <i class="fa fa-thumbs-down fa-flip-horizontal"></i>
                    <p class="dislike_counter"><?=$dislikes?></p>
                  </label>
                </form>
                <script>
                  document.querySelectorAll("#like").forEach(input => {
                    input.onchange = function(){
                      document.getElementById("likeForm").submit();
                    };
                  });
                </script>
              <?php else : ?>
                <label class="checkbox">
                  <input type="checkbox" onclick="document.getElementById('likeDislike').style.display=`block`">
                  <i class="fa fa-star"></i>
                  <p>Favorito</p>
                </label>
                <label class="checkbox">
                  <input type="checkbox" onclick="document.getElementById('likeDislike').style.display=`block`">
                  <i class="fa fa-thumbs-up"></i>
                  <p class="like_counter"><?=$likes?></p>
                </label>
                <label class="checkbox">
                  <input type="checkbox" onclick="document.getElementById('likeDislike').style.display=`block`">
                  <i class="fa fa-thumbs-down fa-flip-horizontal"></i>
                  <p class="dislike_counter"><?=$dislikes?></p>
                </label>
              <?php endif ?>
        </div>
      </div>
    </div>
  </div>
      <?php if(!empty($game['descriptions'])){
        echo'<hr></hr>
        <div class="description">
        <h1 class="title">Descrição</h1>
        <textarea readonly>'.$game["descriptions"].'</textarea></div>';
      }
      ?>
    </div>
  </div> 
  <div id="likeDislike" class="modal">
    <div class="form">
      <span onclick="document.getElementById('likeDislike').style.display=`none`" class="close" title="Fechar Janela">×</span>
      <div class="container" style="max-width:400px;">
        <h3 class="form_title" style="margin-bottom: 1rem;">É necessário iniciar uma sessão</h3>
        <p class="form_text">Você precisa estar conectado para realizar esta ação. Conecte-se ou cadastre-se para continuar.</p>

        <div class="row">
          <a class="modal_link" href="login.php"><button class="form_button" type="button" href="login.php" onclick="document.getElementById('likeDislike').style.display=`none`">Iniciar sessão</button></a>
          <a class="modal_link"><button class="form_button" type="button" onclick="document.getElementById('likeDislike').style.display=`none`">Cancelar</button></a>
        </div>
      </div>
    </div>
  </div>

<?php
  mysqli_free_result($result);
  mysqli_close($conn); 
  }
  
  include_once 'footer.php';
?>