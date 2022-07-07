<?php
  include_once 'header.php';
?>

  <div class="form">
    <div class="container">
      <!-- FORM -->
      <form id="title" action="includes/title.inc.php" method="post">
        <h1 class="form_title">Título</h1>

        <!-- INPUTS -->
        <input class="form_input" type="text" name="title" placeholder="Título">
        <div id="alert" class="form_message"></div>
        <button class="form_button" type="submit" name="submit">Criar</button>
        
      </form>
    </div>
  </div>

<?php
  include_once 'footer.php';
?>