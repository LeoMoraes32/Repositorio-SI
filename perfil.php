<?php

require 'config.php';
require 'dao/UsersDaoMySql.php';
require 'dao/PostsDaoMySql.php';
require 'dao/TagsDaoMySql.php';

require 'components/disciplinas-icons.php';

$usersDao = new UsersDaoMysql($pdo);
$postsDao = new PostsDaoMySql($pdo);
$tagsDao = new TagsDaoMysql($pdo);

$error = false;

session_start();
if ($_SESSION) {
  $id = $_SESSION['id'];
  $name = $_SESSION['name'];
  $email = $_SESSION['email'];
  $senha = $_SESSION['senha'];
  $ano_ingresso = $_SESSION['ano_ingresso'];
  $tipo = $_SESSION['tipo'];
  $imagem = $_SESSION['imagem'];
  $cor = $_SESSION['cor'];
  $entrou = true;
} else {
  header('Location: index.php');
}

$userId = $_GET['user'];
$user = $usersDao->findById($userId);
$lista = $postsDao->findAllforUser($userId);

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- FONTS -->
  <link rel="preconnect" href="https://fonts.gstatic.com">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;
    700&family=Roboto:wght@400;500;700$display=swap">

  <!-- font awesome free -->
  <script src="https://use.fontawesome.com/releases/v5.15.3/js/all.js" crossorigin="anonymous"></script>

  <link rel="stylesheet" href="assets/css/bootstrap.min.css">

  <link href="styles.css" rel="stylesheet" />
  <link rel="sortcut icon" href="https://img.elo7.com.br/product/main/347C7D8/matriz-sistema-de-informacao-sistema-de-informacao.jpg" type="image/jpg" />
  <title>Repositório S.I</title>
</head>

<body>
  <!-- Navigation -->
  <?php
  require('./components/menu.php');
  ?>
  <section>
    <div class="container-fluid perfil">
      <div class="row">
        <?php if ($user->getCover() === NULL) : ?>
          <div style="background-color: #67BB80" class="pb-3">
          <?php else : ?>
            <div style="background-image: linear-gradient(300deg, <?= $user->getCover(); ?>, black)" class="pb-3">
            <?php endif; ?>
            <div class="d-flex flex-column align-items-center text-center p-3">
              <img src="<?php echo 'assets/users-img/' . $user->getImagem(); ?>" style="background-color:white; max-width: 100%; width: 150px; height: 150px; object-fit:cover;" class="rounded-circle" alt="Avatar">
            </div>
            <?php if ($cor) : ?>
              <h5 class="text-center text-white"><i class="fas fa-user"></i> <?php echo $user->getName() ?></h5>
              <h5 class="text-center text-white"><i class="far fa-envelope"></i> <?php echo $user->getEmail() ?></h5>
              <?php if ($user->getAno_ingresso() === NULL) : ?>
                <h5 class="text-white text-center"><i class="fas fa-birthday-cake"></i> Ingressou em... <a href="settings.php" style="color:#383994">Atualize seu Perfil!</a></h5>
              <?php else : ?>
                <h5 class="text-center text-white"><i class="fas fa-birthday-cake"></i> Ingresso no curso desde <?= $user->getAno_ingresso() ?></h5>

              <?php endif; ?>
            <?php else : ?>
              <h5 class="text-white text-center"><?= $user->getName(); ?></h5>
              <h5 class="text-white text-center"><?= $user->getEmail(); ?></h5>
              <?php if ($ano_ingresso === NULL) : ?>
                <h5 class="text-white text-center"><i class="fas fa-birthday-cake"></i> Ingressou em... <a href="settings.php" style="color:#383994">Atualize seu Perfil!</a></h5>
              <?php endif; ?>
            <?php endif; ?>
            <?php if ($userId == $id): ?>
              <div class="text-center">
                <a style="font-size:1rem; border:solid 1px white; background-color:<?=$user->getCover()?>" href="settings.php" type="button" class="btn btn-success"><i class="fas fa-user-edit"></i> Editar Perfil</a>
              </div>
            <?php endif;?>

            </div>
          </div>
      </div>

      <div class="container-fluid color">
        <div class="container">

          <div class="row">
            <div class="col-sm-4">
              <div class="card my-5">
                <div class="card-body">
                  <h6 class="card-title"><i style="margin-right: 0.5rem; color: <?=$user->getCover() ?>" class="verde fab fa-buffer"></i><?=sizeof($lista)?> postagens publicadas</h4>
                  <h6 class="card-title"><i style="margin-right: 0.5rem; color: <?=$user->getCover() ?>" class="verde fas fa-comment"></i>45 comentários escritos</h6>
                  <?php if ($userId == $id): ?>
                  <div class="col text-center">
                    <a style="font-size:1rem; background-color: <?=$user->getCover()?>;" href="criar-post.php" type="button" class="btn btn-success">Criar Post</a>
                  </div>
                  <?php endif; ?>
                </div>
              </div>
            </div>
            <div class="col-sm-8">
              <h2 class="text-center my-2">Postagens de <span class="px-1" style="color: <?=$user->getCover() ?>"><?= $user->getName(); ?></span></h2>
              <?php if ($id != $userId && empty($lista)): ?>
                  <h2 class="text-center mt-5">Perfil sem postagens!</h2>
              <?php elseif($id == $userId && empty($lista)): ?>
                  <h4 class="text-center mt-5">Perfil sem postagens! <i style="color:<?=$user->getCover() ?>"  class="fas fa-frown"></i></h4>
                  <h4 class="text-center">Compartilhe conosco algo! <i style="color:<?=$user->getCover() ?>"  class="fas fa-smile-wink"></i></h4>
              <?php endif; ?>
      
              <?php foreach ($lista as $posts) : ?>
                <?php
                $data = $posts->getCreated_at();

                $arrayData = explode('-', $data);

                $ano = $arrayData[0];
                $mes = $arrayData[1];
                $dia = $arrayData[2];

                $tag = $tagsDao->findById($posts->getId());

                ?>
                <a class="title" href="post.php?post=<?= $posts->getId(); ?>">
                  <div class="card-body card shadow-e px-5 mb-2">
                    <div class="row mt-4 mb-4">
                      <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1 pt-1">
                        <a class="title" href="perfil.php?user=<?= $user->getId(); ?>">
                          <img src="<?php echo 'assets/users-img/' . $user->getImagem() ?>" style="width: auto; height: 40px; " class="rounded-circle" alt="Avatar">
                        </a>
                      </div>
                      <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
                        <a class="title" href="perfil.php?user=<?= $user->getId(); ?>">
                          <p style="margin-bottom: 0;"><small><?php echo $user->getName() ?></small></p>
                        </a>
                        <small class="text-muted"><i class="far fa-calendar"></i> <?= $dia ?>-<?= $mes ?>-<?= $ano ?></small>
                      </div>
                    </div>
                    <a href="post.php?post=<?= $posts->getId(); ?>">
                      <h1 class="mt-0"> <?= $disciplinasIcons[$posts->getDisciplina_id_fk()]; ?> <?= $posts->getTitle(); ?></h1>
                    </a>
                    <div class="faixa">
                      <ul class="mt-2" style="padding-left:0;">
                        <?php for ($i = 0; $i < sizeof($tag); $i++) : ?>
                          <li>
                            <h6><small><i class="fas fa-hashtag"></i> <?php echo $tag[$i]->getTag(); ?></small></h6>
                          </li>
                        <?php endfor; ?>
                      </ul>
                    </div>
                    <a href="post.php?post=<?= $posts->getId(); ?>"><i class="fas fa-chevron-circle-up icone-2"></i>Ver post</a>

                  </div>
                </a>
              <?php endforeach; ?>

            </div>
          </div>
        </div>

      </div>
    </div>
  </section>
  <?php
  require('./components/footer.php');
  ?>

<script type="text/javascript" src="assets/assets2/jquery-3.6.0.min.js"></script>
  <script type="text/javascript" src="assets/assets2/bootstrap.min.js"></script>
  <script type="text/javascript" src="assets/assets2/popper.min.js"></script>

  <script src="assets/js/script.js"></script>
</body>

</html>