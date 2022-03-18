<?php

require 'config.php';
require 'dao/UsersDaoMySql.php';


$usersDao = new UsersDaoMysql($pdo);
$error = false;
$errorJaCadastrado = false;

if (isset($_POST['login'])) {
  $nome = filter_input(INPUT_POST, 'name');
  $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
  $senha = filter_input(INPUT_POST, 'senha');
  $senha2 = filter_input(INPUT_POST, 'senha2');

  if ($senha === $senha2) {
    if ($email && $senha) {
      $user = $usersDao->findByEmail($email);
      if ($user) {
        $errorJaCadastrado = true;
      } else {
        $tipo = 'user';
        $user = $usersDao->add($email, $senha, $nome, $tipo);
        $foto = 'default.jpg';
        $user->setImagem($foto);

        session_start();

        $_SESSION['id'] = $user->getId();
        $_SESSION['name'] = $user->getName();
        $_SESSION['email'] = $user->getEmail();
        $_SESSION['senha'] = $user->getPassword();
        $_SESSION['ano_ingresso'] = $user->getAno_ingresso();
        $_SESSION['tipo'] = $user->getTipo();
        $_SESSION['imagem'] = $user->getImagem();
        $_SESSION['cor'] = $user->getCover();
        header('Location: index.php');
      }
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
  require('./components/cadastrar-menu.php');
  ?>
  <section class="container">
    <div class="container py-5">
      <div class="row d-flex align-items-center justify-content-center">
        <div class="col-md-8 col-lg-7 col-xl-6">
          <img src="assets/img/cadastrar.png" class="img-fluid" alt="Log In image">
        </div>
        <div class="col-md-7 col-lg-5 col-xl-5 offset-xl-1">
          <form method="POST" action="">
            <h2 id="inscreva" class="my-5">Inscreva-se no Repositório</h2>
            <!-- Email input -->

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

            <?php
            if ($errorJaCadastrado) {
              echo '
                            <div class="alert alert-warning d-flex align-items-center" role="alert">
                              <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:"><use xlink:href="#exclamation-triangle-fill"/></svg>
                              <div>
                              Email já cadastrado!
                              </div>
                            </div>
                          ';
            }
            ?>

            <div class="form-outline mb-4">
              <label class="form-label" for="form1Example13">Nome</label>
              <input type="text" name="name" id="name" class="form-control form-control-lg" placeholder="Nome completo" required />
            </div>
            <div class="form-outline mb-4">
              <label class="form-label" for="form1Example13">Email</label>
              <input type="email" name="email" id="email" class="form-control form-control-lg" placeholder="Seu email" required />
            </div>

            <!-- Password input -->

            <div class="form-outline mb-4">
              <label class="form-label" for="form1Example23">Senha</label>
              <input type="password" name="senha" id="senha" class="form-control form-control-lg" placeholder="Sua senha" required />
            </div>

            <div class="form-outline mb-4">
              <label class="form-label" for="form1Example23">Confirmar senha</label>
              <input type="password" name="senha2" id="senha" class="form-control form-control-lg" placeholder="Confirmar senha" required />
            </div>

            <div class="d-flex justify-content-around align-items-center mb-4">
              <!-- Checkbox -->
              <div class="form-check">
                <input class="form-check-input" type="checkbox" value="" id="form1Example3" checked />
                <label class="form-check-label" for="form1Example3"> Remember me </label>
              </div>
              <a href="#!">Esqueceu a senha?</a>
            </div>

            <!-- Submit button -->
            <button name="login" type="submit" class="btn btn-success btn-lg btn-block">Cadastrar</button>

          </form>
          <div class="my-3">
            <p>Já tem uma conta? <a href="login.php">Entrar</a></p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <?php
  require('./components/footer.php');
  ?>

  <script type="text/javascript" src="assets/js/jquery-3.6.0.min.js"></script>
  <script script type="text/javascript" src="assets/js/bootstrap.bundle.min.js"></script>

  <script src="assets/js/script.js"></script>
</body>

</html>