<?php


require 'config.php';
require 'components/disciplinas-icons.php';
require 'dao/UsersDaoMySql.php';
require 'dao/PostsDaoMySql.php';
require 'dao/TagsDaoMySql.php';
require 'dao/DisciplinasDaoMySql.php';

$postsDao = new PostsDaoMySql($pdo);
$usersDao = new UsersDaoMysql($pdo);
$tagsDao = new TagsDaoMySql($pdo);
$disciplinaDao = new DisciplinasDaoMySql($pdo);

$disciplinaId = $_GET['id'];
$lista = $postsDao->findAllforDisciplinas($disciplinaId);
$listas = $postsDao->findLasThree();
$disciplina = $disciplinaDao->findById($disciplinaId);

$postagens = $postsDao->findMoreVisited();


$entrou = false;

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
    <?php if ($disciplina->getAno() == 1) : ?>
        <header class="parallax1" id="main">
        <?php elseif ($disciplina->getAno() == 2) : ?>
            <header class="parallax2" id="main">
            <?php elseif ($disciplina->getAno() == 3) : ?>
                <header class="parallax3" id="main">
                <?php elseif ($disciplina->getAno() == 4) : ?>
                    <header class="parallax4" id="main">
                    <?php else : ?>
                        <header class="parallax5" id="main">
                        <?php endif; ?>
                        <div class="row h-100">
                            <div class="col-md-12 align-self-center">
                                <div class="container my-5">
                                    <h1 class="text-white"><small style="border-radius: 0.3rem; background-color: black; padding: 0rem 1rem 0rem 1rem"><?= $disciplinasIcons[$disciplinaId]; ?> <?= $disciplina->getNome(); ?></small></h1>
                                    <p class="text-white"><span class="font-weight-bold"><i class="fas fa-arrow-circle-right"></i> Ementa:</span> <?= $disciplina->getEmenta(); ?></p>
                                    <?php if ($disciplina->getCarga() != NULL) : ?>
                                        <p class="text-white"><span class="font-weight-bold"><i class="far fa-clock"></i> Carga horária:</span> <?= $disciplina->getCarga(); ?> horas</p>
                                    <?php endif; ?>
                                    <!--
                                    <div class="submit-line">
                                        <input type="text" placeholder="Pesquisar" />
                                        <button class="submit-lente" type="submit">
                                            <i class="fa fa-search"></i>
                                        </button>
                                    </div>
                                    -->
                                </div>
                            </div>
                        </div>

                        </header>


                        <!-- teste  -->



                        <section class="container my-3">
                            <div class="row">
                                <div class="row">
                                    <div class="col-8">
                                        <div class="input-group rounded">
                                            <input type="search" id="busca" class="form-control rounded" placeholder="Pesquisar" aria-label="Search" aria-describedby="search-addon" />
                                            <span class="input-group-text border-0 lupa" id="search-addon">
                                                <i class="fas fa-search"></i>
                                            </span>
                                        </div>
                                        <h2 class="mt-2">Posts relacionados:</h2>
                                    </div>

                                </div>
                                <div class="col-sm-8" id="resultado">
                                    <?php foreach ($lista as $posts) : ?>
                                        <?php

                                        $idUser = $posts->getUsers_id_fk();
                                        $user = $usersDao->findById($idUser);
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
                                                    <h1 class="mt-0 title"> <?= $disciplinasIcons[$posts->getDisciplina_id_fk()]; ?> <?= $posts->getTitle(); ?></h1>
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
                                <div class="col-sm-4">
                                    <h4 class="py-2 my-0 px-2 bg-light"><i class="fas fa-newspaper"></i> Posts Recentes</h4>
                                    <div class="divider-1"></div>
                                    <div class="list-group my-2 ">
                                        <?php foreach ($listas as $lists) : ?>
                                            <?php
                                            $idUser = $lists->getUsers_id_fk();
                                            $user = $usersDao->findById($idUser);
                                            $data = $lists->getCreated_at();

                                            $arrayData = explode('-', $data);

                                            $ano = $arrayData[0];
                                            $mes = $arrayData[1];
                                            $dia = $arrayData[2];

                                            $tag = $tagsDao->findById($lists->getId());


                                            ?>
                                            <a href="post.php?post=<?= $lists->getId(); ?>" class="list-group-item list-group-item-action shadow-e" aria-current="true">
                                                <div class="d-flex w-100 justify-content-between ">
                                                    <h5 class="mb-1"><?= $disciplinasIcons[$lists->getDisciplina_id_fk()]; ?> <?= $lists->getTitle(); ?></h5>
                                                </div>
                                                <!--
                                                <p class="mb-1"><?= mb_strimwidth($lists->getBody(), 0, 50, "..."); ?></p>
                                                --->
                                                <small><i class="far fa-calendar"></i> <?= $dia ?>-<?= $mes ?>-<?= $ano ?></small>
                                            </a>
                                        <?php endforeach; ?>

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
                            function busca() {
                                $("#busca").keyup(function() {
                                    const busca = $("#busca").val();

                                    $.post('faz-busca.php', {
                                        busca: busca
                                    }, function(data) {
                                        $("#resultado").html(data);
                                    });
                                });
                            }

                            if ($("#busca").keyup() || $("#busca").change()) {
                                busca();
                            }
                        </script>

</body>

</html>