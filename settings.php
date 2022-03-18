<?php

require 'components/disciplinas-icons.php';

require 'config.php';
require 'dao/UsersDaoMySql.php';

$usersDao = new UsersDaoMysql($pdo);
$error = false;
$sucesso = false;
$lista = $usersDao->findAll();

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
} else {
    header('Location: index.php');
}

if (isset($_POST['configuration'])) {

    $newNome = filter_input(INPUT_POST, 'name');
    $newEmail = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    $newSenha = filter_input(INPUT_POST, 'senha');
    $newSenha2 = filter_input(INPUT_POST, 'senha2');
    $newData = filter_input(INPUT_POST, 'data');

    if ($newData == 0000 - 00 - 00) {
        $newData = NULL;
    }
    $newImagem = filter_input(INPUT_POST, 'imagem');
    if ($newImagem === NULL) {
        $newImagem = $_SESSION['imagem'];
    }
    $newCor = filter_input(INPUT_POST, 'cor');

    if ($newSenha === $newSenha2) {
        $user = $usersDao->findByEmail($oldEmail);
        if ($user) {

            if (in_array($_FILES['imagem']['type'], array('image/jpeg', 'image/jpg', 'image/png'))) {
                $nomeImagem = $newEmail . '.jpg';
                move_uploaded_file($_FILES['imagem']['tmp_name'], 'assets/users-img/' . $nomeImagem);
                $newImagem = $nomeImagem;
                //redimensionando a imagem
                $caminhoImagem = 'assets/users-img/' . $nomeImagem;
                $altura = "300";
                $largura = "300";

                if ($_FILES['imagem']['type'] == 'image/jpeg') {
                    $imagem_temporaria = imagecreatefromjpeg('assets/users-img/' . $nomeImagem);
                    $largura_original = imagesx($imagem_temporaria);
                    $altura_original = imagesy($imagem_temporaria);

                    $nova_largura = $largura ? $largura : floor(($largura_original / $altura_original) * $altura);
                    $nova_altura = $altura ? $altura : floor(($altura_original / $largura_original) * $largura);

                    $imagem_redimensionada = imagecreatetruecolor($nova_largura, $nova_altura);
                    imagecopyresampled(
                        $imagem_redimensionada,
                        $imagem_temporaria,
                        0,
                        0,
                        0,
                        0,
                        $nova_largura,
                        $nova_altura,
                        $largura_original,
                        $altura_original
                    );
                    imagejpeg($imagem_redimensionada, 'assets/users-img/' . $nomeImagem);
                } else {
                    $imagem_temporaria = imagecreatefrompng('assets/users-img/' . $nomeImagem);
                    $largura_original = imagesx($imagem_temporaria);
                    $altura_original = imagesy($imagem_temporaria);

                    $nova_largura = $largura ? $largura : floor(($largura_original / $altura_original) * $altura);
                    $nova_altura = $altura ? $altura : floor(($altura_original / $largura_original) * $largura);

                    $imagem_redimensionada = imagecreatetruecolor($nova_largura, $nova_altura);
                    imagecopyresampled(
                        $imagem_redimensionada,
                        $imagem_temporaria,
                        0,
                        0,
                        0,
                        0,
                        $nova_largura,
                        $nova_altura,
                        $largura_original,
                        $altura_original
                    );
                    imagepng($imagem_redimensionada, 'assets/users-img/' . $nomeImagem);
                }
            }

            $user->setName($newNome);
            $user->setEmail($newEmail);
            $user->setPassword($newSenha);
            $user->setAno_ingresso($newData);
            $user->setImagem($newImagem);
            $user->setCover($newCor);

            $usersDao->update($user);

            $_SESSION = array();
            session_destroy();
            session_start();
            $_SESSION['id'] = $user->getId();
            $_SESSION['name'] = $user->getName();
            $_SESSION['email'] = $user->getEmail();
            $_SESSION['senha'] = $user->getPassword();
            $_SESSION['ano_ingresso'] = $user->getAno_ingresso();
            $_SESSION['tipo'] = $user->getTipo();
            $_SESSION['imagem'] = $user->getImagem();
            $_SESSION['cor'] = $user->getCover();


            $sucesso = true;
        }
    } else {
        $error = true;
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
    <link rel="sortcut icon" href="https://img.elo7.com.br/product/main/347C7D8/matriz-sistema-de-informacao-sistema-de-informacao.jpg" type="image/jpg" />
    <title>Repositório S.I</title>
</head>

<body>
    <!-- Navigation -->
    <?php
    require('./components/settings-menu.php');
    ?>
    <section class="container-fluid color">
        <div class="container py-4">
            <h4>Configurações para <a href="perfil.php?user=<?= $id; ?>"><?= $email ?></a></h4>

            <div class="card">
                <div class="card-body">
                    <form method="POST" action="" enctype="multipart/form-data">
                        <div class="form-outline mb-4">
                            <div class="col-md-6">
                                <?php
                                if ($sucesso) {
                                    echo '
                                            <div class="alert alert-success" role="alert">
                                            Informações atualizadas com sucesso!
                                            </div>
                                        ';
                                }
                                ?>
                                <label class="form-label labels">Nome completo</label>
                                <input type="text" name="name" id="name" class="form-control" placeholder="Nome completo" value="<?= $name ?>" required>

                                <label class="form-label labels">Email</label>
                                <input type="text" name="email" id="email" class="form-control" placeholder="Email" value="<?= $email ?>" required>

                                <p class="labels my-3">Redefinir senha:</p>
                                <?php
                                if ($error) {
                                    echo '
                                            <div class="alert alert-danger d-flex align-items-center" role="alert">
                                            <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:"><use xlink:href="#exclamation-triangle-fill"/></svg>
                                            <div>
                                            As senhas não conferem!
                                            </div>
                                            </div>
                                        ';
                                }
                                ?>
                                <label class="form-label labels">Senha</label>
                                <input type="password" name="senha" id="senha" class="form-control" placeholder="Senha" value="<?= $senha ?>">

                                <label class="form-label labels">Confirmar senha</label>
                                <input type="password" name="senha2" id="senha2" class="form-control" placeholder="Confirme senha" value="<?= $senha ?>">

                                <label class="form-label labels">Ano de ingresso no curso</label>
                                <input type="date" name="data" id="data" class="form-control" placeholder="AAAA-MM-DD" value="<?= $ano_ingresso ?>">

                                <label class="form-label labels">Imagem de perfil</label>
                                <img src="<?php echo 'assets/users-img/' . $imagem ?>" style="width: auto; height: 45px;" class="rounded-circle" alt="Avatar">
                                <input type="file" name="imagem" id="imagem" class="px-2">

                                <label class="form-label labels new-label">Cor do fundo</label>
                                <div class="col-md-3">
                                    <input type="color" name="cor" id="cor" value="<?= $cor ?>" class="form-control">
                                </div>
                            </div>
                        </div>

                        <div class="col text-center my-3">
                            <button name="configuration" type="submit" class="btn btn-success">Salvar informações de perfil</button>
                        </div>
                    </form>
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
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery.maskedinput/1.4.1/jquery.maskedinput.min.js"></script>
    <script>

    </script>
    <script src="assets/js/script.js"></script>
</body>

</html>