<?php

require 'config.php';
require 'components/disciplinas-icons.php';
require 'dao/UsersDaoMySql.php';
require 'dao/PostsDaoMySql.php';
require 'dao/TagsDaoMySql.php';
require 'dao/DisciplinasDaoMySql.php';

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

    <div class="container">
        <h3 class="text-muted">Sistema de Busca</h3>
        <form>
            <input autocomplete="off" id="busca" type="text" class="form-control" placeholder="Buscar cliente">
        </form>
    </div>
    <div class="container" id="resultado">
        <?php
        $postsDao = new PostsDaoMySql($pdo);
        $usersDao = new UsersDaoMysql($pdo);
        $tagsDao = new TagsDaoMySql($pdo);
        $lista = $postsDao->findAll();
        ?>
    

        <div class="container">
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


                <div class="card">
                    <h6>
                        <?= $posts->getTitle(); ?>
                    </h6>
                    <p>

                    </p>

                </div>
            <?php endforeach; ?>
        </div>

    </div>
    <script type="text/javascript" src="assets/js/jquery-3.6.0.min.js"></script>
    <script type="text/javascript" src="assets/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/script.js"></script>
    <script>
        $("#busca").keyup(function() {
            const busca = $("#busca").val();
            $.post('faz-busca.php', {
                busca: busca
            }, function(data) {
                $("#resultado").html(data);
            });
        });
    </script>
</body>

</html>