<?php
error_reporting(0);
ini_set('display_errors', 0);

require 'config.php';
require 'dao/UsersDaoMySql.php';
require 'dao/PostsDaoMySql.php';
require 'components/disciplinas-icons.php';
require 'dao/TagsDaoMySql.php';

$postsDao = new PostsDaoMySql($pdo);
$usersDao = new UsersDaoMysql($pdo);
$tagsDao = new TagsDaoMySql($pdo);

$lista = $postsDao->findAll();

$entrou = false;

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
    <?php
      require('./components/menu.php');
    ?>

    <!-- Navigation -->
        
    <header class="parallax" id="main">
        
        <div class="row h-100">
            <div class="col-md-12 align-self-center">
                <div class="container col-md-6 justify-content-center">
                    <h1 class="text-center text-white">Bem vindo! <br>Busque pelo assunto desejado abaixo!</h1>
                    <div class="submit-line">
                      <input type="text" placeholder="Pesquisar" />
                      <button class="submit-lente" type="submit">
                        <i class="fa fa-search"></i>
                      </button>
                    </div>
                </div>
              </div>
          </div>

    </header>
    

    <!-- teste  -->

    

    <section class="container my-5">
        <div class="row">
          <div class="row justify-content-around">
            <div class="col-4">
              <h2>Posts</h2>
            </div>
            <?php
            if($entrou){
              echo ' <div class="col-6">
              <a href="criar-post.php" class="px-lg-3 btn btn-success">Criar Post</a></li>
            </div>';
            }
            ?>
          </div>        
          <div class="col-sm-8">
                <?php foreach($lista as $posts):
                $idUser = $posts->getUsers_id_fk();
                $user = $usersDao->findById($idUser);
                $data = $posts->getCreated_at();
                
                    $arrayData = explode('-',$data);

                    $ano = $arrayData[0];
                    $mes = $arrayData[1];
                    $dia = $arrayData[2];

                    $tag = $tagsDao->findById($posts->getId());
                ?>
                <div class="card-body shadow-e px-5">
                    <div class="row mt-4 mb-4">
                        <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1 pt-1">
                            <img src="<?php echo 'assets/users-img/'.$user->getImagem() ?>" style="width: auto; height: 40px; " class="rounded-circle" alt="Avatar">
                        </div>
                        <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
                            <p style="margin-bottom: 0;"><small><?php echo $user->getName()?></small></p>
                            <small class="text-muted"><i class="far fa-calendar"></i> <?=$dia?>-<?=$mes?>-<?=$ano?></small>
                        </div>
                    </div>
                    <h2 class="mt-0"> <?=$disciplinasIcons[$posts->getDisciplina_id_fk()];?> <?=$posts->getTitle();?></h2>
                    <div class="faixa">
                        <ul class="mt-2" style="padding-left:0;">
                            <?php for($i = 0; $i<sizeof($tag); $i++): ?>
                                <li><h6><small><i class="fas fa-hashtag"></i> <?php echo $tag[$i]->getTag(); ?></small></h6></li>
                            <?php endfor; ?>
                        </ul>
                    </div>
                    <a href="post.php?post=<?=$posts->getId();?>"><i class="fas fa-chevron-circle-up icone-2"></i>Ver post</a>
                    
                </div>
                <?php endforeach; ?>
            </div>
            <div class="col-sm-4 mt-5">
                <h4>Posts Recentes</h4>
                <div class="divider-1"></div>
                <div class="list-group my-2">
                    <a href="#" class="list-group-item list-group-item-action" aria-current="true">
                      <div class="d-flex w-100 justify-content-between">
                        <h5 class="mb-1">List group item heading</h5>
                        <small>3 dias atrás</small>
                      </div>
                      <p class="mb-1">Some placeholder content in a paragraph.</p>
                      <small>And some small print.</small>
                    </a>
                    <a href="#" class="list-group-item list-group-item-action">
                      <div class="d-flex w-100 justify-content-between">
                        <h5 class="mb-1">List group item heading</h5>
                        <small>3 dias atrás</small>
                      </div>
                      <p class="mb-1">Some placeholder content in a paragraph.</p>
                      <small>And some muted small print.</small>
                    </a>
                    <a href="#" class="list-group-item list-group-item-action">
                      <div class="d-flex w-100 justify-content-between">
                        <h5 class="mb-1">List group item heading</h5>
                        <small>3 dias atrás</small>
                      </div>
                      <p class="mb-1">Some placeholder content in a paragraph.</p>
                      <small>And some muted small print.</small>
                    </a>
                  </div>
                  <h4>Categorias</h4>
                  <div class="divider-1"></div>
                <div class="list-group my-2">
                    <a href="#" class="list-group-item list-group-item-action" aria-current="true">
                      <div class="d-flex w-100 justify-content-between">
                        <h5 class="mb-1">List group item heading</h5>
                        <small>(3)</small>
                      </div>
                   
                    </a>
                    <a href="#" class="list-group-item list-group-item-action">
                      <div class="d-flex w-100 justify-content-between">
                        <h5 class="mb-1">List group item heading</h5>
                        <small>(3)</small>
                      </div>
                     
                    </a>
                    <a href="#" class="list-group-item list-group-item-action">
                      <div class="d-flex w-100 justify-content-between">
                        <h5 class="mb-1">List group item heading</h5>
                        <small>(3)</small>
                      </div>
                    
                    </a>
                  </div>
            </div>
          </div>
    </section>

    <?php
      require('./components/footer.php'); 
    ?>

    <script type="text/javascript" src="assets/js/jquery-3.6.0.min.js"></script>
    <script type="text/javascript" src="assets/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/script.js"></script>
   
</body>
</html>