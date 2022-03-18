<?php 

require 'config.php';
require 'dao/UsersDaoMySql.php';

$usersDao = new UsersDaoMysql($pdo);
$lista = $usersDao->findAll();
$error = false;

if(isset($_POST['login'])) {
  $email = filter_input(INPUT_POST, 'email-entrar', FILTER_VALIDATE_EMAIL);
  $senha = filter_input(INPUT_POST, 'senha-entrar');
  if($email && $senha){
    $user = $usersDao->findByEmailAndPassword($email, $senha);
    if(!$user){
      $error = true;
    }else {
      session_start();
      $_SESSION['id'] = $user->getId();
      $_SESSION['name'] = $user->getName();
      $_SESSION['email'] = $user->getEmail();
      $_SESSION['senha'] = $user->getPassword();
      $_SESSION['ano_ingresso'] = $user->getAno_ingresso();
      $_SESSION['tipo'] = $user->getTipo();
      $_SESSION['imagem'] = $user->getImagem();
      $_SESSION['cor'] = $user->getCover();

      $error = false;
      header('Location: index.php');
    }

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
      require('./components/login-menu.php');
    ?>
    
    <section class="container">
      <div class="container py-5">
        <div class="row d-flex align-items-center justify-content-center">
          <div class="col-md-8 col-lg-7 col-xl-6">
            <img src="assets/img/login.png" class="img-fluid" alt="Log In image">
          </div>
          <div class="col-md-7 col-lg-5 col-xl-5 offset-xl-1">
          <form method="POST" action="">
                    <h2 id="entrar" class="my-5">Entrar no Repositório</h2>
                    <!-- Email input -->
                    <?php
                        if($error){
                          echo'
                            <div class="alert alert-danger d-flex align-items-center" role="alert">
                              <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:"><use xlink:href="#exclamation-triangle-fill"/></svg>
                              <div>
                              Email ou senha incorretos
                              </div>
                            </div>
                            ';
                        }
                        ?>
                    <div class="form-outline mb-4">
                      <label class="form-label" for="form1Example13">Email</label>
                      <input type="email" name="email-entrar" id="email-entrar" class="form-control form-control-lg" placeholder="Seu email" required/>
                    </div>
          
                    <!-- Password input -->
                    <div class="form-outline mb-4">
                      <label class="form-label" for="form1Example23">Senha</label>
                      <input type="password" name="senha-entrar" id="senha-entrar" class="form-control form-control-lg" placeholder="Sua senha" required/>
                    </div>
          
                    <div class="d-flex justify-content-around align-items-center mb-4">
                      <!-- Checkbox -->
                      <div class="form-check">
                        <input
                          class="form-check-input"
                          type="checkbox"
                          value=""
                          id="form1Example3"
                          checked
                        />
                        <label class="form-check-label" for="form1Example3"> Remember me </label>
                      </div>
                      <a href="#!">Esqueceu a senha?</a>
                    </div>
          
                    <!-- Submit button -->
                    <button name="login" type="submit" class="btn btn-success btn-lg btn-block">Entrar</button>
          
                  </form>
                  <div class="my-3">
                    <p>Não tem uma conta? <a href="cadastrar.php">Cadastre-se</a></p>
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