<?php

// Verifica se as váriaveis estão vazias
function emptyInput(array $variables){
  $result = "";
  if(count(array_filter($variables)) == count($variables)) {
    return false;
  }else{
    return true;
  }
}

// Compara a palavra-passe com o do utilizador
function checkPwd($conn, $username, $pwd){
  session_start();
  $uidExists = uidExists($conn, $username, $username);

  $pwdHashed = $uidExists["usersPwd"];
  $checkPwd = password_verify($pwd, $pwdHashed);
  
  if ($checkPwd === true) { 
    return true;
  }else if($checkPwd === false){ 
    return false;
  }
}

// LIKES E DISLIKES
// Verifica se o utilizador ja deu like ou dislike no jogo
function checkLike($conn, $creation_id, $type){
  session_start();
  $user_id = $_SESSION["userid"];

  $sql = "SELECT * FROM likes WHERE users_id = '$user_id' AND creation_id='$creation_id'";
  if(!$result = mysqli_query($conn, $sql)){
    echo mysqli_error($conn);
    exit();
  }else{
    if (mysqli_num_rows($result) > 0) {
      return true;
    }else{
      return false;
    }
  }
  mysqli_close($conn);
}

// Tira o like ou dislike da tabela
function unlike($conn, $creation_id, $type){
  $user_id = $_SESSION["userid"];

  $sql = "DELETE FROM likes WHERE users_id = '$user_id' AND creation_id='$creation_id'";
  if (!mysqli_query($conn, $sql)) { 
    echo mysqli_error($conn);
    exit();
  }else{
    header("location: ../gamepage.php?id=$creation_id&error=none-unlike&type=$type"); 
  }
  mysqli_close($conn);
}

// Adiciona o like ou dislike da tabela e aumenta 1 valor do total
function like($conn, $creation_id, $type){
  $user_id = $_SESSION["userid"];

  $sql = "INSERT INTO likes (users_id, creation_id, types) VALUES ('$user_id' ,'$creation_id', '$type')";
  if (!mysqli_query($conn, $sql)) { 
    echo mysqli_error($conn);
    exit();
  }else{
    header("location: ../gamepage.php?id=$creation_id&error=none-like&type=$type"); 
  }
  mysqli_close($conn);
}


// FAVORITOS
// Verifica se o utilizador ja meteu como favorito o jogo
function checkFav($conn, $creation_id){
  session_start();
  $user_id = $_SESSION["userid"];

  $sql = "SELECT * FROM favorites WHERE users_id = '$user_id' AND creation_id='$creation_id'";
  if(!$result = mysqli_query($conn, $sql)){
    echo mysqli_error($conn);
    exit(); 
  }else{
    if (mysqli_num_rows($result) > 0) {
      return true;
    }else{
      return false;
    }
  }
  mysqli_close($conn);
}

// Tira o favorito da tabela
function unFav($conn, $creation_id){
  $user_id = $_SESSION["userid"];

  $sql= "DELETE FROM favorites WHERE users_id = '$user_id' AND creation_id='$creation_id'";

  if (!mysqli_query($conn, $sql)) { 
    echo mysqli_error($conn);
    exit(); 
  }else{
    header("location: ../gamepage.php?id=$creation_id&error=none-unfav"); 
  }
  mysqli_close($conn);
}

// Adiciona o jogo aos favoritos
function fav($conn, $creation_id){
  $user_id = $_SESSION["userid"];

  $sql = "INSERT INTO favorites (users_id, creation_id) VALUES ('$user_id' ,'$creation_id')";

  if (!mysqli_query($conn, $sql)) { 
    echo mysqli_error($conn);
    exit();
  }else{
    header("location: ../gamepage.php?id=$creation_id&error=none-fav"); 
  }
  mysqli_close($conn);
}


// EDITAR PERFIL
function editProf($conn, $name, $email, $pwd){
  session_start();
  $user_id = $_SESSION["userid"];
  $username= $_SESSION["userid"];

  if (checkPwd($conn, $username, $pwd) !== false) {
    header("location: ../settings.php?tab=profedit&error=wrongpassword");
    exit();
  }else{
    $sql = "UPDATE users SET usersName='$name', usersEmail='$email' WHERE id = $user_id";
    
    if (!mysqli_query($conn, $sql)) { 
      echo mysqli_error($conn);
      exit(); 
    }else{
      header("location: ../settings.php?tab=profedit&error=none"); 
    }
  }
  mysqli_close($conn);
}


// IMAGENS
// Verifica se a extensão da imagem é válida.
function imageExt($imageName) {
  $result = "";
  $validImageExtension = ['jpg', 'jpeg', 'png'];
  $imageExtension = explode('.', $imageName);
  $imageExtension = strtolower(end($imageExtension));
  if (!in_array($imageExtension, $validImageExtension)){
    $result = true;
  }else{
    $result = false;
  }
  return $result;
}

// Verifica se o tamanho da imagem é maior do que 12MB
function imageSize($imageSize) {
  $result = "";
  if ($imageSize > 1200000){
    $result = true;
  }else{
    $result = false;
  }
  return $result;
}

// Muda a imagem
function changeImage($conn, $imageName, $tmpName, $table, $column, $name, $id, $page) {
  
  $sql = "SELECT * FROM $table WHERE id = '$id'";
  if (!$result = mysqli_query($conn, $sql)) { 
    echo mysqli_error($conn);
    exit();
  }else{
    $row = mysqli_fetch_assoc($result);
    $oldImage = $row[$column];
    if ($oldImage == "game-big.jpg" || $oldImage == "game-small.jpg" || $oldImage == "profile-default.jpg"){
    }else{
      unlink("../img/".$oldImage);
    }
  }

  $caracteres_sem_acento = array(
    'Š'=>'S', 'š'=>'s', 'Ð'=>'Dj',''=>'Z', ''=>'z', 'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A',
    'Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E', 'Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I',
    'Ï'=>'I', 'Ñ'=>'N', 'Ń'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O', 'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U', 'Ú'=>'U',
    'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 'Þ'=>'B', 'ß'=>'Ss','à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a',
    'å'=>'a', 'æ'=>'a', 'ç'=>'c', 'è'=>'e', 'é'=>'e', 'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i',
    'ï'=>'i', 'ð'=>'o', 'ñ'=>'n', 'ń'=>'n', 'ò'=>'o', 'ó'=>'o', 'ô'=>'o', 'õ'=>'o', 'ö'=>'o', 'ø'=>'o', 'ù'=>'u',
    'ú'=>'u', 'û'=>'u', 'ü'=>'u', 'ý'=>'y', 'ý'=>'y', 'þ'=>'b', 'ÿ'=>'y', 'ƒ'=>'f',
    'ă'=>'a', 'î'=>'i', 'â'=>'a', 'ș'=>'s', 'ț'=>'t', 'Ă'=>'A', 'Î'=>'I', 'Â'=>'A', 'Ș'=>'S', 'Ț'=>'T',
  );
  
  $name = strtr($name, $caracteres_sem_acento);
  $imageExtension = explode('.', $imageName);
  $imageExtension = strtolower(end($imageExtension));
  $newImageName = $name . "-" . date("Y.m.d") . "-" . date("h.i.s"); // gera um novo nome para a imagem
  $newImageName .= '.' . $imageExtension;
  $query = "UPDATE $table SET $column = '$newImageName' WHERE id = '$id'";
  mysqli_query($conn, $query);
  move_uploaded_file($tmpName, '../img/' . $newImageName);
  header("location: ".$page."error=none"); 
  mysqli_close($conn);
}

// JOGOS
// Cria o conteúdo
function createContent($conn, $part, $story, $choiceA, $nextA, $choiceB, $nextB, $choiceC, $nextC, $choiceD, $nextD, $type, $id, $next) {
  session_start();
  $creation_id = $_SESSION["creationid"];

  $sql = "INSERT INTO content (creation_id, part, story, choiceA, nextA, choiceB, nextB, choiceC, nextC, choiceD, nextD, contentType) VALUES ('$creation_id', '$part', '$story', '$choiceA', '$nextA', '$choiceB', '$nextB', '$choiceC', '$nextC', '$choiceD', '$nextD', '$type')";
  
  if (!mysqli_query($conn, $sql)) { 
    echo mysqli_error($conn);
    exit();
  }else{
    $last_id = $conn->insert_id;
    $_SESSION["lastContent"] = $last_id;
    if (!empty($id) && !empty($next)){
      $sql = "UPDATE content SET next$next='$last_id' WHERE id='$id'";
      if (!mysqli_query($conn, $sql)) { 
        echo mysqli_error($conn);
        exit();
      }
    }
    checkInicio($conn, $last_id, $type);
    header("location: ../create.php?id=".$creation_id."&operacao=editar&error=insert-none"); 
  }
  mysqli_close($conn);
}

// Edita o conteúdo
function editContent($conn, $id, $part, $story, $choiceA, $nextA, $choiceB, $nextB, $choiceC, $nextC, $choiceD, $nextD, $type) {
  session_start();
  $creation_id = $_SESSION["creationid"];

  $sql = "UPDATE content SET part='$part', story='$story', choiceA='$choiceA', nextA='$nextA', choiceB='$choiceB', nextB='$nextB', choiceC='$choiceC', nextC='$nextC', choiceD='$choiceD', nextD='$nextD', contentType='$type' WHERE id='$id' AND creation_id='$creation_id'";
  $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
  if ($result == true){
    checkInicio($conn, $id, $type);
    header("location: ../create.php?id=".$creation_id."&operacao=editar&error=edit-none"); 
  }
}

// Verifica se o jogo ja tem um começo e modifica a base de dados conforme necessário.
function checkInicio($conn, $id, $type) {
  session_start();
  $creation_id = $_SESSION["creationid"];

  if ($type == 1){
    $sql = "SELECT * FROM content WHERE creation_id='$creation_id'";
    if (!mysqli_query($conn, $sql)) { 
      echo mysqli_error($conn);
      exit();
    } else { 
      $sql = "UPDATE content SET contentType=2 WHERE creation_id='$creation_id' AND contentType=1 AND id!='$id'";
      if (!mysqli_query($conn, $sql)) { 
        echo mysqli_error($conn);
        exit();
      }
    }
  }
}

// Apaga a criação ou conteudo
function deleteCreation($conn, $id, $table){
  session_start();
  $creation_id = $_SESSION["creationid"];

  if ($table == "creations"){
    $page = "location: ../profile.php?tab=profc&";
    $sql = "DELETE FROM content WHERE creation_id='$id'";
    mysqli_query($conn, $sql);
    $sql = "DELETE FROM likes WHERE creation_id='$id'";
    mysqli_query($conn, $sql);
    $sql = "DELETE FROM favorites WHERE creation_id='$id'";
    mysqli_query($conn, $sql);
  }elseif($table == "content"){
    $page = "location: ../create.php?id=$creation_id&operacao=editar&";
    $sql = array(
      "UPDATE content SET nextA='0' WHERE nextA='$id'",
      "UPDATE content SET nextB='0' WHERE nextB='$id'",
      "UPDATE content SET nextC='0' WHERE nextC='$id'",
      "UPDATE content SET nextD='0' WHERE nextD='$id'"
    );
    for ($i=0; $i < count($sql); $i++) { 
      mysqli_query($conn, $sql[$i]);
    } 
  } 

  $sql2 = "DELETE FROM $table WHERE id='$id' ";
  if (!mysqli_query($conn, $sql2)) { 
    echo mysqli_error($conn);
    exit();
  }else{ 
    header($page."error=none-apagar");
    exit();
  } 

  mysqli_close($conn);
}

// Verifica se as variáveis estão vazias
function emptyOperation($id, $operacao, $table) {
  $result = "";
  if (empty($id) || $operacao!="apagar" || empty($table)) {
    $result = true;
  }else{
    $result = false;
  }
  return $result;
}

// Verifica se o título é válido
function invalidTitle($title) {
  $result = "";
  if (preg_match("#[[:punct:]]#", "", $title)) {
    $result = true;
  }else{
    $result = false;
  }
  return $result;
}

// Cria o jogo
function createCreation($conn, $title) {
  $createdAt = date("Y-m-d");
  session_start();
  $creator_id = $_SESSION["userid"];

  $sql = "INSERT INTO creations (creator_id, title, createdAt) VALUES ('$creator_id', '$title', '$createdAt')";

  if (!mysqli_query($conn, $sql)) { 
    echo mysqli_error($conn);
    exit();
  }
  else{ 
    $creation_id = $conn->insert_id;
    header("location: ../create.php?id=".$creation_id."&operacao=editar");
    session_start();
    $_SESSION["creationid"] = $creation_id;
  } 

  mysqli_close($conn);
}

// Edita o jogo
function editGame($conn, $title, $description){
  session_start();
  $creation_id = $_SESSION["creationid"];

  $sql = "UPDATE creations SET title='$title', descriptions='$description' WHERE id = $creation_id";
  
  if (!mysqli_query($conn, $sql)) { 
    echo mysqli_error($conn);
    exit(); 
  }else{
    header("location: ../createsettings.php?error=none"); 
  }
  mysqli_close($conn);
}


// MUDAR PALAVRA-PASSE
function changePwd($conn, $oldPwd, $newPwd){
  session_start();
  $user_id= $_SESSION["userid"];
  $username = $_SESSION["useruid"];
  $uidExists = uidExists($conn, $username, $username);

  $pwdHashed = $uidExists["usersPwd"];
  $checkPwd = password_verify($oldPwd, $pwdHashed);
  
  if (checkPwd($conn, $username, $oldPwd) === false) {
    header("location: ../settings.php?tab=pwd&error=wrongpwd");
    exit();
  }else{ 
    $hashedPwd = password_hash($newPwd, PASSWORD_DEFAULT); // Encripta a palavra-passe
    $sql = "UPDATE users SET usersPwd='$hashedPwd' WHERE id='$user_id'"; 

    if (!mysqli_query($conn, $sql)) { 
      echo mysqli_error($conn);
      exit(); 
    }else{ 
      header("location: ../settings.php?tab=pwd&error=none");
      exit();
    }
  }

  mysqli_close($conn);
}


// CRIAR CONTA
// Verifica se o nome de utilizador é válido
function invalidUid($username) {
  $result = "";
  if (!preg_match("/^[a-zA-Z0-9]*$/", $username)) {
    $result = true;
  }else{
    $result = false;
  }
  return $result;
}

// Verifica se as palavra-passes coincidem.
function pwdMatch($pwd, $pwdRepeat) {
  $result = "";
  if ($pwd !== $pwdRepeat) {
    $result = true;
  }else{
    $result = false;
  }
  return $result;
}

// Verifica se o nome de utilizador já foi tomado
function uidExists($conn, $username, $email) {
  $sql = "SELECT * FROM users WHERE usersUid = ? OR usersEmail = ?;";
  $stmt = mysqli_stmt_init($conn);
  if (!mysqli_stmt_prepare($stmt, $sql)) {
    echo mysqli_error($conn);
    exit();
  }

  mysqli_stmt_bind_param($stmt, "ss", $username, $email);
  mysqli_stmt_execute($stmt);

  $resultData = mysqli_stmt_get_result($stmt);

  if ($row = mysqli_fetch_assoc($resultData)) {
    return $row;
  }else{
    $result = false;
    return $result;
  }

  mysqli_stmt_close($stmt);
}

// Cria a conta
function createUser($conn, $name, $username, $email, $pwd) {
  $sql = "INSERT INTO users (usersName, usersUid, usersEmail, usersPwd, usersRegAt) VALUES (?, ?, ?, ?, ?);";
  $stmt = mysqli_stmt_init($conn);
  if (!mysqli_stmt_prepare($stmt, $sql)) {
    echo mysqli_error($conn);
    exit();
  }

  $hashedPwd = password_hash($pwd, PASSWORD_DEFAULT); // Encripta a palavra-passe
  $date = date("Y-m-d");

  mysqli_stmt_bind_param($stmt, "sssss", $name, $username, $email, $hashedPwd, $date);
  mysqli_stmt_execute($stmt);
  mysqli_stmt_close($stmt);
  header("location: ../login.php?error=none");
}


// LOGIN
// Entra na conta
function loginUser($conn, $username, $pwd) {
  $uidExists = uidExists($conn, $username, $username);

  if ($uidExists === false) {
    header("location: ../login.php?error=wronglogin");
    exit();
  }
  
  if (checkPwd($conn, $username, $pwd) === false) {
    header("location: ../login.php?error=wronglogin");
    exit();
  }else{ 
    // Declara variavéis de sessão
    $_SESSION["userid"] = $uidExists["id"];
    $_SESSION["useruid"] = $uidExists["usersUid"];
    $creator_id = $_SESSION["userid"];

    $date = date("Y-m-d");
    $sql = "UPDATE users SET usersLastLogin='$date' WHERE id='$creator_id'"; 

    if (!mysqli_query($conn, $sql)) { 
      echo mysqli_error($conn);
      exit();
    }else{ 
      header("location: ../index.php");
    }
  }

  mysqli_close($conn);
}

// EXTRAS
// Retorna a percentagem de lieks
function likePercent($conn, $creation_id){
  $sql = "SELECT * FROM likes WHERE creation_id='$creation_id' AND types=1";
  if ($result = mysqli_query($conn, $sql)){
    $likes = mysqli_num_rows($result);
  }

  $sql = "SELECT * FROM likes WHERE creation_id='$creation_id' AND types=2";
  if ($result = mysqli_query($conn, $sql)){
    $dislikes = mysqli_num_rows($result);
  }

  $total = $likes + $dislikes;
  if($likes == null){
    $percent = 0;
  }else{
    $percent = round(($likes / $total) * 100);
  }
  return $percent;

  mysqli_close($conn);
}
?>