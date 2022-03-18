<?php 
require 'config.php';
require 'models/Users.php';
require 'dao/PostsDaoMySql.php';

$postsDao = new PostsDaoMySql($pdo);
$lista = $postsDao->findAll();

$entrou = false;

echo '<pre>';
print_r( $_FILES);

$newNome = filter_input(INPUT_POST, 'name');
$newEmail = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
$newSenha = filter_input(INPUT_POST, 'senha');
$newSenha2 = filter_input(INPUT_POST, 'senha2');
$newData = filter_input(INPUT_POST, 'data');
$newImagem = filter_input(INPUT_POST, 'imagem');

if(in_array($_FILES['imagem']['type'], array('image/jpeg', 'image/jpg', 'image/png'))){
  $nomeImagem = $newEmail.'.jpg';

  $nomeImagem2 = 'assets/users-img/'.$nomeImagem;
  $arquivo = $nomeImagem2;
  $maxWidth = 719;
  $maxHeight = 713;
  
  $mime = getimagesize($arquivo);
  list($originalWidth, $originalHeight) = getimagesize($arquivo);

  $ratio = $originalWidth / $originalHeight;
  $ratioDest = $maxWidth / $maxHeight;

  $finalWidth = 0;
  $finalHeight = 0;

  if($ratioDest > $ratio) {
    $finalWidth = $maxHeight * $ratio;
    $finalHeight = $maxHeight;
  } else {
    $finalHeight = $maxWidth / $ratio;
    $finalWidth = $maxWidth;
  }

  $imagemNova = imagecreatetruecolor($finalWidth, $finalHeight);
  if($mime['mime'] === 'image/jpeg'){
    $originalImg = imagecreatefromjpeg($arquivo);
    imagecopyresampled(
      $imagemNova, 
      $originalImg, 0, 0, 0, 0, 
      $finalWidth, $finalHeight, 
      $originalWidth, $originalHeight
    );
    imagejpeg($imagemNova, $nomeImagem, 100);
    move_uploaded_file($imagemNova, 'assets/users-img/'.$nomeImagem);
  } else {

  }

  echo $finalWidth. ' - '.$finalHeight;
  echo '<br>';
  print_r($mime['mime']);
  echo '<br>';
  
  
  move_uploaded_file($_FILES['imagem']['tmp_name'],'assets/users-img/'.$nomeImagem);
}



echo $newNome;
echo $newEmail;
echo $newData;
var_dump($newImagem);


?>