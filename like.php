<?php
require 'config.php';
require 'dao/UsersDaoMySql.php';
require 'dao/PostsDaoMySql.php';
require 'dao/TagsDaoMySql.php';
require 'dao/DisciplinasDaoMySql.php';
require 'dao/PostLikesDaoMySql.php';

$usersDao = new UsersDaoMysql($pdo);
$postsDao = new PostsDaoMySql($pdo);
$tagsDao = new TagsDaoMySql($pdo);
$disciplinasDao = new DisciplinasDaoMySql($pdo);
$postLikesDao = new PostLikesDaoMySql($pdo);

$acao = $_POST['acao'];
$idPost = $_POST['idPost'];
session_start();
?>
<?php if ($_SESSION): ?>
<?php
    $id = $_SESSION['id'];
    $name = $_SESSION['name'];
    $email = $_SESSION['email'];
    $senha = $_SESSION['senha'];
    $ano_ingresso = $_SESSION['ano_ingresso'];
    $imagem = $_SESSION['imagem'];
    $cor = $_SESSION['cor'];
    $entrou = true;
    $likeId;
?>
    <?php if($acao%2 == 1): ?>
        <?php
            $postLikes = $postLikesDao->findById($idPost, $id);
            if($postLikes){
                $postLikes = $postLikesDao->deleteLike($postLikes->getId());
            }
            $postLikesNumber = $postLikesDao->getNumberOfLikes($idPost);
        ?>
            <p><i class="far fa-heart"></i> Curtir(<?=$postLikesNumber?>)</p>
    <?php else: ?>
        <?php 
            $datetime = date_create();
            $postLikes = $postLikesDao->add($idPost, $id);
            $postId = $postLikes->getId();
            $postLikesNumber = $postLikesDao->getNumberOfLikes($idPost);
        ?>
        <p><i class="fas fa-heart" style="color:red;"></i> Curtir(<?=$postLikesNumber ?>)</p>
    <?php endif; ?>
<?php endif; ?>