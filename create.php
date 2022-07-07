<?php
  include_once 'header.php';
  include 'includes/dbh.inc.php';

  if ($_SERVER["REQUEST_METHOD"] == "GET") { 
    $id = filter_input(INPUT_GET, 'id'); 
    $operacao = filter_input(INPUT_GET, 'operacao'); 

    if (empty($id) || $operacao!="editar"){ 
      header("location: ../create.php?id=".$id."&operacao=editar&error=invalidrequest");
      exit(); 
    }     
  } 
  else{ 
    header("location: ../create.php?id=".$id."&operacao=editar&error=invalidrequest2");
    exit();
  } 
  $_SESSION["creationid"] = $id;
  $lastContent = $_SESSION["lastContent"];
  $sql = "SELECT * FROM creations WHERE id = '$id' "; 


  if (!$result = mysqli_query($conn, $sql)) { 
    echo mysqli_error($conn);
    mysqli_close($conn);
  }else{ 
    $row = mysqli_fetch_assoc($result);
?>

<div class="top_bar">
  <div class="inner_bar">
    <div class="section">
      <a href="createinsertform.php?id=&next="><i class="fa fa-plus"></i></a>
      <form id="create" action="includes/create.inc.php" method="post">
    </div>
    <div class="section">
      <h2 class="title"><?php echo $row['title'] ?></h2>
    </div>
    <form>
      <div class="section">
        <a href="createsettings.php"><i class="fa fa-gear"></i></a>
      </div>
    </form>
  </div>
</div>

<script>
  // Armazena o número no cache
  function store(number){
    localStorage.setItem("content", number);
  }

  // Faz o scroll
  function scrollToContent(){
    var number = localStorage.getItem("content");
    var content = document.querySelector("[data-id='"+number+"']");
    var contentPosition = content.getBoundingClientRect().top;
    var offsetAmount = 125;
    var offsetPosition = contentPosition + window.pageYOffset - offsetAmount;
    console.log("number = "+number)
    console.log("contentPos = "+contentPosition)
    create.scrollTo({
      top: offsetPosition,
      behavior: 'instant'
    });

    content.style.animation = 'flash .5s 5';
    localStorage.setItem("content", null);
  }


  var test = <?php if($lastContent!==null){
    echo $lastContent;
  } else{
    echo "null";
  }?>;

  if (test !== null){
    store(test);
  }
</script>

<div class="create">
<?php 
  $sql = "SELECT * FROM content WHERE creation_id='$id' ORDER BY contentType ASC, part"; 

  if (!$result = mysqli_query($conn, $sql)) { 
    echo mysqli_error($conn);
    mysqli_close($conn);
  } else { 
    $i=1;
    foreach($result as $row2){
      $A = $row2["nextA"];
      $B = $row2["nextB"];
      $C = $row2["nextC"];
      $D = $row2["nextD"];
      if (!$result = mysqli_query($conn, $sql)) { 
        echo mysqli_error($conn);
        mysqli_close($conn);
      } else { 
        foreach($result as $row3){
          if ($row3["id"] == $A) {
            $A = $row3["part"];
          }
          if ($row3["id"] == $B) {
            $B = $row3["part"];
          }
          if ($row3["id"] == $C) {
            $C = $row3["part"];
          }
          if ($row3["id"] == $D) {
            $D = $row3["part"];
          }
        }
      }
      switch ($row2['contentType']) {
        case 1:
          $type='<i class="fa-solid fa-star"></i>';
          break;
        case 2:
          $type='';
          break;
        case 3:
          $type='<i class="fa-solid fa-flag"></i>';
          break;
      }

      echo  '<div class="content" data-id="'.$row2["id"].'">
              <div class="btns">
                <h3 class="part">'.$row2["part"].$type.'</h3>
                <a onclick="store('.$row2["id"].')" href="createeditform.php?id='.$row2['id'].'&operacao=editar"><i class="fa fa-pen-to-square set"></i></a>
                <a onclick="document.getElementById(`'.$i.'`).style.display=`block`")"><i class="fa fa-trash set"></i></a>
              </div>
              <textarea class="story" readonly>'.$row2["story"].'</textarea>
              <a class="link-btn" href="createinsertform.php?id='.$row2["id"].'&next=A"><p class="choice"><b>A. </b>'.$row2["choiceA"].' <i class="fa fa-arrow-right"></i> '.$A.'</p></a>
              <a class="link-btn" href="createinsertform.php?id='.$row2["id"].'&next=B"><p class="choice"><b>B. </b>'.$row2["choiceB"].' <i class="fa fa-arrow-right"></i> '.$B.'</p></a>
              <a class="link-btn" href="createinsertform.php?id='.$row2["id"].'&next=C"><p class="choice"><b>C. </b>'.$row2["choiceC"].' <i class="fa fa-arrow-right"></i> '.$C.'</p></a>
              <a class="link-btn" href="createinsertform.php?id='.$row2["id"].'&next=D"><p class="choice"><b>D. </b>'.$row2["choiceD"].' <i class="fa fa-arrow-right"></i> '.$D.'</p></a>
            </div>
            <div id="'.$i.'" class="modal">
              <div class="form">
                <span onclick="document.getElementById(`'.$i.'`).style.display=`none`" class="close" title="Fechar Janela">×</span>
                <div class="container" style="max-width:400px;">
                  <h2 class="form_title">Apagar Secção</h2>
                  <p class="form_text">Tens certeza que queres apagar esta secção?</p>
                  <h3 class="form_input">'.$row2["part"].'</h3>

                  <div class="row">
                    <a class="modal_link" href="includes/createdelete.inc.php?id='.$row2['id'].'&operacao=apagar&table=content"><button type="button" onclick="document.getElementById(`'.$i.'`).style.display=`none`" class="form_button delete">Apagar</button></a>
                    <a class="modal_link"><button type="button" onclick="document.getElementById(`'.$i.'`).style.display=`none`" class="form_button">Cancelar</button></a>
                  </div>
                </div>
              </div>
            </div>';
      $i++;
    }
  }
?>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
  // Esconde o header quando der scroll
  var create = document.querySelector(".create");
  scrollToContent();

  $(document).ready(function() {
    var header = document.getElementById("header"); 
    var html = document.querySelector("html");
    html.style.overflow = "hidden";

    $(create).scroll(function() {
      if ($(this).scrollTop() > 0) {
        $(create).height("calc(100vh - 50px - 2rem)");
        header.style.display = "none";
      } else {
        $(create).height("calc(100vh - 100px - 2rem)");
        header.style.display = "block";
      }
    });
  });
</script>

<?php  
  $_SESSION["lastContent"] = null;
  mysqli_free_result($result);
  mysqli_close($conn);       
  } 
?> 