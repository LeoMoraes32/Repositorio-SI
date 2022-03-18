<?php
header('Content-Type: application/json');

require 'config.php';
require 'dao/ComentariosDaoMySql.php';

$comentariosDao = new ComentariosDaoMySql($pdo);

$idPost = $_GET['idPost'];

$comentarios = $comentariosDao->findAllforPost($idPost);
print_r($comentarios);
if($comentarios){
    echo json_encode('Comentário salvo com sucesso');
}else{
    echo json_encode('Nenhum comentário encontrado');
}

?>

