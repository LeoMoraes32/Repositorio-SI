<?php 

require 'config.php';
require 'dao/UsersDaoMySql.php';
require 'dao/PostsDaoMySql.php';
require 'components/disciplinas-icons.php';
require 'dao/TagsDaoMySql.php';
require 'dao/DisciplinasDaoMySql.php';

$postsDao = new PostsDaoMySql($pdo);
$usersDao = new UsersDaoMysql($pdo);
$tagsDao = new TagsDaoMySql($pdo);
$disciplinasDao = new DisciplinasDaoMySql($pdo);

$entrou = false;

$busca = $_GET['busca'];
$categoria = $_GET['categoria'];

session_start();
if($_SESSION){
    $id = $_SESSION['id'];
    $name = $_SESSION['name'];
    $email = $_SESSION['email'];
    $senha = $_SESSION['senha'];
    $ano_ingresso = $_SESSION['ano_ingresso'];
    $tipo = $_SESSION['tipo'];
    $imagem = $_SESSION['imagem'];
    $cor = $_SESSION['cor'];
    $entrou = true;
}

if($categoria == 1){
    $lista = $postsDao->findLike($busca);
}
if($categoria == 2){
    $listaUsers = $usersDao->findLike($busca);
    $i = 0;
    for($i = 0; $i < count($listaUsers); $i++){
        $arrayUsers[$i] = $listaUsers[$i]->getId();
    }
}
if($categoria == 3){
    $listaTags = $tagsDao->findLike($busca);
    for($i = 0; $i < count($listaTags); $i++){
        $arrayTags[$i] = $listaTags[$i]->getId_post_fk();
    }
}
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
  <link rel="sortcut icon" href="assets/img/si.jpg" type="image/jpg" />
  <title>Repositório S.I</title>
</head>

<body>
<?php
  require('./components/menu.php');
  ?>

  <!-- Navigation -->

  <header class="parallax" id="main">

    <div class="row h-100">
      <div class="col-md-12 align-self-center mt-5">
        <div class="container col-md-12 justify-content-center">
          <h1 class="text-white">Bem vindo! <br>Busque pelo assunto desejado abaixo!</h1>
          <h6 class="text-white texto"></h6>
          <!--
          <div class="submit-line">
            <input id="busca" type="text" placeholder="Pesquisar" />
            <button class="submit-lente" type="submit">
              <i class="fa fa-search"></i>
            </button>
          </div>
-->
        </div>
      </div>
    </div>

  </header>
  <section class="container my-3">
    <div class="row">
      <div class="row">
        <div class="col-sm-8">
            <form action="pesquisa.php" method="GET">
                <div class="input-group rounded">
                    <input autocomplete="off"  value="<?=$busca?>" id="busca" name="busca" type="search" class="form-control rounded" placeholder="Pesquisar" aria-label="Search" aria-describedby="search-addon" />
                    <button type="submit"   class="input-group-text border-0 lupa" id="search-addon">
                        <i class="fas fa-search"></i>
                    </button>
                    <div class="form-group">
                            <select id="categoria" name="categoria" class=" mx-2" style="border: 1px solid #ced4da; border-radius:0.25rem; width:100%; padding: 0.375rem 0.75rem;">
                            <?php if($categoria == 1): ?>
                            <option selecetd value="1">Posts</option>
                            <option value="2">Usuários</option>
                            <option value="3">Tags</option>
                            <?php endif; ?>

                            <?php if($categoria == 2): ?>
                            <option value="1">Posts</option>
                            <option selected value="2">Usuários</option>
                            <option value="3">Tags</option>
                            <?php endif; ?>

                            <?php if($categoria == 3): ?>
                            <option value="1">Posts</option>
                            <option value="2">Usuários</option>
                            <option selected value="3">Tags</option>
                            <?php endif; ?>
                            </select>
                    </div>
                </div>
            </form>
        </div>
      </div>
    <!-- categoria 1 -->
    <?php if($categoria == 1): ?>
        <div class="col-sm-8">
        <h2> Total de posts: <span style="color:#198754"><?=sizeof($lista)?></span></h2>
        <?php foreach($lista as $posts): ?>
            <?php 

            $idUser = $posts->getUsers_id_fk();
            $user = $usersDao->findById($idUser);
            $data = $posts->getCreated_at();

            $arrayData = explode('-',$data);
            
            $ano = $arrayData[0];
            $mes = $arrayData[1];
            $dia = $arrayData[2];
  
            $tag = $tagsDao->findById($posts->getId());
            ?>
            <a class="title" href="post.php?post=<?= $posts->getId(); ?>">
            <div class="card-body card shadow-e px-5 mb-2">
              <div class="row mt-4 mb-4">
                <div class="col-xs-2 col-sm-2 col-md-2 col-lg-1 pt-1">
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
                <h1 class="mt-0 title"> <?= $disciplinasIcons[$posts->getDisciplina_id_fk()]; ?> <?= $posts->getTitle(); ?></h1>
              </a>
              <div class="faixa">
                <ul class="mt-2" style="padding-left:0;">
                  <?php for ($i = 0; $i < sizeof($tag); $i++) : ?>
                    <li>
                      <h6><small><a href="tag.php?tag=<?=$tag[$i]->getTag()?>"><i class="fas fa-hashtag"></i> <?php echo $tag[$i]->getTag(); ?></a></small></h6>
                    </li>
                  <?php endfor; ?>
                </ul>
              </div>
              <a href="post.php?post=<?= $posts->getId(); ?>"><i class="fas fa-chevron-circle-up icone-2"></i>Ver post</a>
              
            </div>
          </a>
          <?php endforeach; ?>
        </div>
    <?php endif; ?>
    <!-- categoria 2 -->
    <?php if($categoria == 2): ?>
    <div class="col-sm-8">
        <h2> Total de usuários: <span style="color:#198754"><?=sizeof($arrayUsers)?></span></h2>
        <?php for($i = 0; $i < count($arrayUsers); $i++): ?>
            <?php 
                $posts = $postsDao->findAllforUser($arrayUsers[$i]);
                ?>
                <?php foreach($posts as $post): ?>
                <?php
                $idUser = $post->getUsers_id_fk();
                $user = $usersDao->findById($idUser);
                $data = $post->getCreated_at();
        
                $arrayData = explode('-',$data);
        
                $ano = $arrayData[0];
                $mes = $arrayData[1];
                $dia = $arrayData[2];
        
                $tag = $tagsDao->findById($post->getId());
            ?>
        <a class="title" href="post.php?post=<?= $post->getId(); ?>">
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
            <a href="post.php?post=<?= $post->getId(); ?>">
                <h1 class="mt-0 title"> <?= $disciplinasIcons[$post->getDisciplina_id_fk()]; ?> <?= $post->getTitle(); ?></h1>
            </a>
            <div class="faixa">
                <ul class="mt-2" style="padding-left:0;">
                    <?php for ($z = 0; $z < sizeof($tag); $z++) : ?>
                        <li>
                            <h6><small><a href="tag.php?tag=<?=$tag[$z]->getTag()?>"><i class="fas fa-hashtag"></i> <?php echo $tag[$z]->getTag(); ?></a></small></h6>
                        </li>
                        <?php endfor; ?>
                    </ul>
                </div>
                <a href="post.php?post=<?= $post->getId(); ?>"><i class="fas fa-chevron-circle-up icone-2"></i>Ver post</a>
                
            </div>
        </a>
        <?php endforeach; ?>
        <?php endfor; ?>
    </div>
    <?php endif; ?>
    <!-- categoria 3 -->
    <?php if($categoria == 3): ?>
    <div class="col-sm-8">
        <h2> Total de posts: <span style="color:#198754"><?=sizeof($arrayTags)?></span></h2>
        <?php for($i = 0; $i < count($arrayTags); $i++): ?>
            <?php
                $posts = $postsDao->findById($arrayTags[$i]);
                $idUser = $posts->getUsers_id_fk();
                $user = $usersDao->findById($idUser);
                $data = $posts->getCreated_at();
        
                $arrayData = explode('-',$data);
        
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
                <h1 class="mt-0 title"> <?= $disciplinasIcons[$posts->getDisciplina_id_fk()]; ?> <?= $posts->getTitle(); ?></h1>
            </a>
            <div class="faixa">
                <ul class="mt-2" style="padding-left:0;">
                    <?php for ($z = 0; $z < sizeof($tag); $z++) : ?>
                        <li>
                            <h6><small><a href="tag.php?tag=<?=$tag[$z]->getTag()?>"><i class="fas fa-hashtag"></i> <?php echo $tag[$z]->getTag(); ?></a></small></h6>
                        </li>
                        <?php endfor; ?>
                    </ul>
                </div>
                <a href="post.php?post=<?= $posts->getId(); ?>"><i class="fas fa-chevron-circle-up icone-2"></i>Ver post</a>
                
            </div>
        </a>
        
        <?php endfor; ?>
        </div>
        <?php endif; ?>
        <div class="col-sm-4">
        <?php
        if ($entrou) {
          echo ' <div class="col-6 mb-4 text-center">
                          <a href="criar-post.php" class="px-lg-3 btn btn-success">Criar Post</a></li>
                        </div>';
        }
        ?>
        <h4 class="py-2 my-0 px-2 bg-light"><i class="fas fa-eye"></i> Posts mais vistos</h4>
        <div class="divider-1"></div>
        <div class="list-group my-2">
        <?php $postagens = $postsDao->findMoreVisited(); ?>
          <?php for ($i = 0; $i <= 2; $i++) : ?>
            <?php
            $userId = $postagens[$i]->getUsers_id_fk();
            $User = $usersDao->findById($userId);
            $date = $postagens[$i]->getCreated_at();

            $dataArray = explode('-', $date);

            $ano = $dataArray[0];
            $mes = $dataArray[1];
            $dia = $dataArray[2];

            $tags = $tagsDao->findById($postagens[$i]->getId());

            ?>
            <a href="post.php?post=<?= $postagens[$i]->getId(); ?>" class="list-group-item list-group-item-action">
              <div class="d-flex w-100 justify-content-between">
                <h5 class="mb-1"><?= $disciplinasIcons[$postagens[$i]->getDisciplina_id_fk()]; ?> <?= $postagens[$i]->getTitle(); ?></h5>
                <small></small>
              </div>
              <!--
              <p class="mb-1"><?= mb_strimwidth($postagens[$i]->getBody(), 0, 50, "..."); ?></p>
          -->
              <small><i class="far fa-calendar"></i> <?= $dia ?>-<?= $mes ?>-<?= $ano ?></small>
            </a>
          <?php endfor; ?>

        </div>
        <!--
        <h4 class="py-2 my-0 px-2 bg-light"><i class="fas fa-hashtag"></i> Hashtags</h4>
        <div class="divider-1"></div>
        <div class="list-group my-2">

          <div class="d-flex w-100 faixa">
            <ul class="mt-2" style="padding-left:0;">
              <?php
              $allTags = $tagsDao->findAll();
              ?>
              <?php for ($i = 0; $i < sizeof($allTags); $i++) : ?>
                <a href="tag.php?tag=<?=$allTags[$i]->getTag();?>" class="tags px-2" aria-current="true">
                  <li>
                    <h6><small><i class="fas fa-hashtag"></i> <?php echo $allTags[$i]->getTag(); ?></small></h6>
                  </li>
                </a>
              <?php endfor; ?>
            </ul>
          </div>
          !-->
          <h4 class="py-2 my-0 px-2 bg-light"><i class="fas fa-sort-amount-up"></i> Categorias mais usadas</h4>
                            <div class="divider-1"></div>
                            <div class="list-group my-2 ">
                                <?php
                                $disciplinas = $disciplinasDao->findMoreUsed();
                                ?>
                                <?php foreach ($disciplinas as $lista) : ?>
                                    <a href="disciplina.php?id=<?= $lista->getId(); ?>" class="list-group-item list-group-item-action">
                                        <div class="d-flex w-100 justify-content-between">
                                            <h5 class="mb-1"><?= $disciplinasIcons[$lista->getId()] ?> <?= $lista->getNome(); ?></h5>
                                            <small>(<?= $lista->getQtd_posts() ?>)</small>
                                        </div>

                                    </a>
                                <?php endforeach; ?>
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
  <script>
      function busca(){
        $("#busca").keyup(function() {
        const busca = $("#busca").val();
        
        $.post('faz-busca.php', {
          busca: busca
        }, function(data) {
          $("#resultado").html(data);
        });
      });
      }
   
      if($("#busca").keyup() || $("#busca").change() ){
        busca();
      }



    
    var text = "Compartilhe, estude e pratique!";
    var index = 0;
    var type = setInterval(function() {
      document.querySelector(".texto").textContent += text[index];

      index += 1;

      if(index > text.length -1){
        clearInterval(type);
      }
    }, 150);

  </script>
    </body>
</html>