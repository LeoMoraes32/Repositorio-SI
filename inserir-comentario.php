<?php
require 'config.php';
require 'dao/ComentariosDaoMySql.php';

$comentariosDao = new ComentariosDaoMySql($pdo);

$idPost = $_POST['idPost'];
$idPessoa = $_POST['idPessoa'];
$comment = $_POST['comentario'];

$datetime = date_create();

$comentariosDao->add($idPost, $idPessoa, $datetime->format('Y-m-d'), $comment);

?>