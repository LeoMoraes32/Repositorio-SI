<?php


require 'config.php';
require 'dao/ComentariosDaoMySql.php';
require 'dao/UsersDaoMySql.php';

$comentariosDao = new ComentariosDaoMySql($pdo);
$usersDao = new UsersDaoMysql($pdo);

$idPost = $_GET['idPost'];

$comentarios = $comentariosDao->findAllforPost($idPost);
?>

<?php if($comentarios): $count=1; ?>
<?php foreach($comentarios as $comments): ?>
    <?php
    $count = $count +1;

    $idUser = $comments->getId_user();
    $user = $usersDao->findById($idUser);
    ?>
    
    <div class="row mt-1">
        <div class="container">
        <div class="card d-flex flex-row comment-row py-3 shadow-e">
                <div class="p-2"><img src="<?php echo 'assets/users-img/' . $user->getImagem() ?>" style="width: auto; height: 60px; " class="rounded-circle" alt="Avatar"></div>
                <div class="comment-text w-100">
                <h6 class="font-medium"><?=$user->getName();?></h6> <span class="m-b-15 d-block"><?=$comments->getBody();?></span>
                <div class="comment-footer"><i class="far fa-calendar"></i> - <?=$comments->getCreated_at()?> <span class="text-muted float-right"><i</span> 
                <br>
                <button data-toggle="collapse" href="#collapseExample<?=$count?>" aria-expanded="false" aria-controls="collpaseExample<?=$count?>" style="background-color:#d3d3d3; font-size:14px" type="button" class="btn btn-cyan btn-sm"><i class="fas fa-trash-alt"></i></button></div>
                <div class="collapse" id="collapseExample<?=$count?>">
  <div class="mt-2 card card-body">
    Deletar comentário?<br>
    <div class="row">
      <div class="col-sm-2">
        <a href="deletar-comentario.php"><i style="color:green" class="fas fa-check"></i></a>
      </div>
      <div class="col-sm-2">
        <a data-toggle="collapse" href="#collapseExample<?=$count?>" aria-expanded="false" aria-controls="collpaseExample<?=$count?>" type="button"><i style="color:red" class="fas fa-times"></i></a>
      </div>
  </div>
  
  </div>
</div>
            </div>
        </div>
        </div>
    </div>
    




   
<?php endforeach; ?>
<?php endif; ?>




<?php 

exit;

?>
