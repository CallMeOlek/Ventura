<?php
  include_once 'header.php';
  include 'includes/dbh.inc.php';
  include 'includes/functions.inc.php';
?>

  <div class="main index">
    <!-- GRID -->
    <div style="width: 100%;" class="page page_active"> 

    <?php   

    $sql = 'SELECT * FROM creations'; 
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
                      <span>'.likePercent($conn, $row["id"]).'%<i class="fa fa-thumbs-up"></i></span>
                      <span style="display: none;">2k<i class="fa fa-eye"></i></span>
                    </div>
                  </div>
                </div>
              </a>';
      }
    mysqli_free_result($result);
    mysqli_close($conn); 
    }
    ?>


    </div>
  </div>

<?php
  include_once 'footer.php';
?>