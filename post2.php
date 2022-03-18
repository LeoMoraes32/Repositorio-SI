<?php

require 'config.php';
require 'dao/UsersDaoMySql.php';
require 'dao/PostsDaoMySql.php';
require 'dao/TagsDaoMySql.php';
require 'dao/DisciplinasDaoMySql.php';
require 'dao/PostLikesDaoMySql.php';

require 'components/disciplinas-icons.php';

$usersDao = new UsersDaoMysql($pdo);
$postsDao = new PostsDaoMySql($pdo);
$tagsDao = new TagsDaoMySql($pdo);
$disciplinasDao = new DisciplinasDaoMySql($pdo);
$postLikesDao = new PostLikesDaoMySql($pdo);

$postagens = $postsDao->findMoreVisited();

$error = false;
$sucesso = false;
$lista = $usersDao->findAll();

$entrou = false;

session_start();
if ($_SESSION) {
    $oldEmail = $_SESSION['email'];
    $id = $_SESSION['id'];
    $name = $_SESSION['name'];
    $email = $_SESSION['email'];
    $senha = $_SESSION['senha'];
    $ano_ingresso = $_SESSION['ano_ingresso'];
    $imagem = $_SESSION['imagem'];
    $cor = $_SESSION['cor'];
    $entrou = true;

    $postId = $_GET['post'];
    $postLikesPerson = $postLikesDao->findById($postId, $id);
}
$postId = $_GET['post'];

$postLikes = $postLikesDao->getNumberOfLikes($postId);

$postsDao->updateVisit($postId);
$post = $postsDao->findById($postId);
$user = $usersDao->findById($post->getUsers_id_fk());
$tag = $tagsDao->findById($post->getId());
$data = $post->getCreated_at();

$arrayData = explode('-', $data);

$ano = $arrayData[0];
$mes = $arrayData[1];
$dia = $arrayData[2];

$arrayMes = array("", "Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro");
for ($i = 0; $i <= sizeof($arrayMes); $i++) {
    if ($mes == $i) {
        $mes = $arrayMes[$i];
    }
}
function tempoEstimado($tamArrayBody)
{
    $min = ceil($tamArrayBody / 200);
    return $min;
}

$body = $post->getBody();
$arrayBody = explode(" ", $body);
$tamArrayBody = sizeof($arrayBody);

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
    <style>
        #demo img {
            height: 100%;
            width: 100%;
        }
    </style>
</head>

<body>
    <!-- Navigation -->
    <?php
    require('./components/menu.php');
    ?>
    <section class="container-fluid">
        <div class="container">
            <div class="container">

                <div class="row">

                    <!-- Blog Entries Column -->
                    <div class="col-lg-8">

                        <!-- Author -->

                        <div class="row mt-4 mb-4">
                            <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1 pt-1">

                                <img src="<?php echo 'assets/users-img/' . $user->getImagem() ?>" style="width: auto; height: 40px; " class="rounded-circle" alt="Avatar">
                            </div>
                            <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
                                <h6><small><?php echo $user->getName() ?></small></h6>
                                <small class="text-muted"><i class="far fa-calendar"></i> Postado em <?= $dia ?> de <?= $mes ?>, <?= $ano ?></small>
                            </div>
                            <?php if ($entrou && $id == $post->getUsers_id_fk()) : ?>
                                <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                                    <div class="faixa">
                                        <ul>
                                            <li style="background-color:#d3d3d3; border-radius:0.2rem;">
                                                <a class="mx-1" href="editar-post.php?id=<?= $postId ?>" style="font-size: 0.8rem; "><i class="fas fa-edit"></i>editar</a>
                                            </li>
                                            <li style="background-color:#d3d3d3; border-radius:0.2rem;">
                                                <a class="mx-1" href="" style="font-size: 0.8rem;"><i class="fas fa-trash-alt"></i>deletar</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- Title -->
                        <h1 class="font-weight-bold display-4"><?= $disciplinasIcons[$post->getDisciplina_id_fk()] ?> <?= $post->getTitle(); ?></h1>

                        <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8 ml-5">
                            <div class="row">
                                <div class="faixa">
                                    <ul class="mt-2" style="padding-left:0;">
                                        <?php foreach ($tag as $tags) : ?>
                                            <li>
                                                <h6><small><i class="fas fa-hashtag"></i> <?php echo $tags->getTag(); ?></small></h6>
                                            </li>
                                        <?php endforeach; ?>
                                        <?php if (tempoEstimado($tamArrayBody) <= 25) : ?>
                                            <h6><small><i class="far fa-clock"></i> Tempo de leitura: <?= tempoEstimado($tamArrayBody); ?> minutos</small></h6>
                                        <?php elseif ($tamArrayBody == 200) : ?>
                                            <h6><small><i class="far fa-clock"></i> Tempo de leitura: <?= tempoEstimado($tamArrayBody); ?> minuto</small></h6>
                                        <?php else : ?>
                                            <h6><small><i class="far fa-clock"></i> Boa Leitura!</small></h6>
                                        <?php endif; ?>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="divider-1 mb-2"></div>


                        <div id="demo">
                            <?= $post->getBody(); ?>
                        </div>

                        <div class="divider-1 mb-2"></div>
                        <div class="faixa">
                            <?php if($_SESSION): ?>
                            <ul class="mt-2" style="padding-left:0;">
                                    <button style="border:0px; background-color:white;" id="like">
                                        <li>
                                            <div id="result">
                                                <?php if(!$postLikesPerson): ?> 
                                                <p><i class="far fa-heart"></i> Curtir(<?=$postLikes?>)</p>
                                                <?php else: ?>
                                                <p><i class="fas fa-heart" style="color:red;"></i> Curtir(<?=$postLikes?>)</p>
                                                <?php endif; ?>
                                            </div>
                                        </li>
                                    </button>
                                

                                <a href="#">
                                    <li>
                                        <p><i class="fas fa-comment-alt"></i></p>
                                    </li>
                                </a>
                            </ul>
                            <?php else: ?>
                            <p><i class="fas fa-lightbulb"></i> Crie uma conta para comentar e curtir a postagem!</p>
                            <?php endif; ?>
                        </div>
                        <!-- Comments Form -->
                        <div class="card my-4">
                            <h5 class="card-header">Deixe um comentário:</h5>
                            <div class="card-body ">
                                <form id="comentario">
                                    <div class="form-group">
                                        <textarea class="form-control" id="comment" name="comment" rows="3"></textarea>
                                    </div>
                                    <input type="submit" form="comentario" class="mt-2 btn btn-success" value="Enviar Comentário"></input>
                                </form>
                            </div>
                        </div>

                        <!-- Single Comment -->
                        <div id="comments" class="media mb-4 comments">
                           
                        </div>

                     

                    </div>

                    <!-- Sidebar Widgets Column -->
                    <div class="col-md-4 my-4">

                        <!-- Search Widget -->
                        <h4 class="py-2 my-0 px-2 bg-light"><i class="fas fa-eye"></i> Posts mais vistos</h4>
                        <div class="divider-1"></div>
                        <div class="list-group my-2">
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
                            <h4 class="py-2 my-0 px-2 bg-light"><i class="fas fa-hashtag"></i> Hashtags</h4>
                            <div class="divider-1"></div>
                            <div class="list-group my-2">

                                <div class="d-flex w-100 faixa">
                                    <ul class="mt-2" style="padding-left:0;">
                                        <?php
                                        $allTags = $tagsDao->findAll();
                                        ?>
                                        <?php for ($i = 0; $i < sizeof($allTags); $i++) : ?>
                                            <a href="#" class="tags px-2" aria-current="true">
                                                <li>
                                                    <h6><small><i class="fas fa-hashtag"></i> <?php echo $allTags[$i]->getTag(); ?></small></h6>
                                                </li>
                                            </a>
                                        <?php endfor; ?>
                                    </ul>
                                </div>
                                
                            </div>

                        </div>
                        <!-- /.row -->
                                            
                    </div>
                    <!-- /.container -->

                </div>
    </section>

    <?php
    require('./components/footer.php');
    ?>
    

    <script type="text/javascript" src="assets/assets2/jquery-3.6.0.min.js"></script>
    
    <script type="text/javascript" src="assets/assets2/bootstrap.min.js"></script>

    <script type="text/javascript" src="assets/assets2/popper.min.js"></script>
    <script type="text/javascript" src="assets/js/script.js"></script>
    <script>
        $(document).ready(function() {            

            var acao = 0;
            $("#like").click(function() {
                var idPost = '<?=$postId?>';
                acao = acao + 1;
                $.post("like.php", {
                    acao: acao,
                    idPost: idPost
                }, function(data){
                    $("#result").html(data);
                });
            });


            const demo = document.querySelectorAll('#demo');
            demo.forEach(element => {
                document.demo.img.style.height = "100";
            });

        });

        $("#comentario").submit(function(e){
                e.preventDefault();
                var idPost = '<?=$postId?>';
                var idPessoa = '<?=$_SESSION['id']?>';
                var comment = $('#comment').val();

                $.ajax({
                    url: 'inserir-comentario.php',
                    method: 'POST',
                    data: { 
                        comentario: comment, 
                        idPessoa: idPessoa,
                        idPost: idPost
                    },
                    dataType: 'json'
                }).done(function(result){
                    $('#comment').val('');
                    getComments();
                });
        });
        function getComments() {
            var idPost = '<?=$postId?>';
            $.ajax({
                url: 'selecionar-comentario2.php',
                type: 'GET',
                data: { idPost: idPost },
                success: function(result){
                    console.log(result);
                    $(".comments").html(result);
                },
                error: function(xhr, ajaxOptions, thrownError){
                    
                    alert(xhr.status);
                    alert(thrownError);
                }

            })
        }
        getComments();
       

    </script>
</body>

</html>