<?php
    include_once 'header.php';
?>

  <div class="form">
    <div class="container" style="min-width:400px;">
      <!-- FORM -->
      <form id="createAccount" action="includes/signup.inc.php" method="post">
        <h1 class="form_title">Cadastre-se</h1>
        
        <!-- INPUTS -->
        <input class="form_input" type="text" name="name" placeholder="Nome">
        <input class="form_input" type="text" name="uid" placeholder="Nome de utilizador">
        <input class="form_input" type="email" name="email" placeholder="Email">
        <input class="form_input" type="password" name="pwd" placeholder="Palavra-passe">
        <input class="form_input" type="password" name="pwdrepeat" placeholder="Repetir palavra-passe">
        <div id="alert" class="form_message"></div>
        <button  class="form_button" type="submit" name="submit">Cadastrar-se</button>
        
        <!-- TEXT -->
        <p class="form_text">
        Já possui uma conta? <a class="form_link" href="login.php" id="linkLogin"><b>Iniciar sessão</b></a>
        </p>
      </form>
    </div>
  </div>

<?php
    include_once 'footer.php';
?>