<?php
require 'config.php';
require 'dao/UsersDaoMySql.php';
$usersDao = new UsersDaoMysql($pdo);
session_start();
$user = $usersDao->findById(1);
var_dump($user->getId());
echo '<br>';
var_dump($user->getImagem());
echo '<br>';
var_dump($user->getName());
echo '<br>';
var_dump($user->getEmail());
echo '<br>';
var_dump($user->getPassword());
echo '<br>';
var_dump($user->getAno_ingresso());
echo '<br>';
var_dump($user->getImagem());
echo '<br>';
var_dump($user->getCover());


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    

    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <script src="assets/tinymce/tinymce.min.js" referrerpolicy="origin"></script>


    <title>Document</title>
</head>
<body>
    

<div class="container">
    <form method="POST" action="bug.php" enctype="multipart/form-data">
        <input type="text" class="form-control" name="tituloPost" id="tituloPost" aria-describedby="titleHelps" placeholder="Novo título da postagem aqui...">
        <textarea id='mytextarea' name="mytextarea">
        
        </textarea>
        
        <div class="col text-center my-3">
            <button name="post" type="submit" class="btn btn-success">Salvar informações de perfil</button>
        </div>

    </form>
</div>




<script type="text/javascript" src="assets/js/jquery-3.6.0.min.js"></script>

<script type="text/javascript" src="assets/js/bootstrap.bundle.min.js"></script>
<script>
    tinymce.init({
        selector: '#mytextarea',
        height: 400,
        plugins: [
            'advlist autolink lists link image charmap print preview anchor',
            'searchreplace visualblocks code fullscreen',
            'insertdatetime media table paste imagetools wordcount'
        ],
        toolbar: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
        images_upload_url: 'upload.php',

        
    });
</script>
</body>
</html>