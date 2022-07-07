<?php
  include_once 'header.php';

  $_SESSION["lastContent"] = null;
?>

  <div class="form">
    <div class="container" style="min-width:400px;">
      <!-- FORM -->
      <form id="login" action="includes/login.inc.php" method="post">
        <h1 class="form_title">Inicie a sessão</h1>

        <!-- INPUTS -->
        <input class="form_input" type="text" name="uid" placeholder="Utilizador/Email">
        <input class="form_input" type="password" name="pwd" placeholder="Palavra-Passe">
        <div id="alert" class="form_message"></div>
        <button class="form_button" type="submit" name="submit">Iniciar sessão</button>
        
        <!-- TEXT -->
        <p class="form_text">
          <a class="form_link" href="#" style="display:none;">Esqueceu-se da palavra-passe?</a>
        </p>
        <p class="form_text">
        Não possui uma conta? <a class="form_link" href="signup.php" id="linkCreateAccount"><b>Cadastrar-se</b></a>
        </p>
      </form>
    </div>
  </div>

  <script>
    localStorage.setItem("tab", "1");
  </script>

<?php
  include_once 'footer.php';
?>