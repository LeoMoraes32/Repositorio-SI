<?php

require 'config.php';
require 'components/disciplinas-icons.php';
require 'dao/UsersDaoMySql.php';
require 'dao/PostsDaoMySql.php';
require 'dao/TagsDaoMySql.php';
require 'dao/DisciplinasDaoMySql.php';

$busca = $_POST['busca'];

$postsDao = new PostsDaoMySql($pdo);
$usersDao = new UsersDaoMysql($pdo);
$tagsDao = new TagsDaoMySql($pdo);


  $posts = $postsDao->findLike($busca);

?>
<h2 id="tam">Total de posts:<span style="color:#198754 "> <?=sizeof($posts) ?></span></h2>
<?php 
if(sizeof($posts) > 0):
    foreach($posts as $lista): ?>
    <?php

$idUser = $lista->getUsers_id_fk();
$user = $usersDao->findById($idUser);
$data = $lista->getCreated_at();

$arrayData = explode('-', $data);

$ano = $arrayData[0];
$mes = $arrayData[1];
$dia = $arrayData[2];

$tag = $tagsDao->findById($lista->getId());


?>  

        <a class="title" href="post.php?post=<?= $lista->getId(); ?>">
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
              <a href="post.php?post=<?= $lista->getId(); ?>">
                <h1 class="mt-0 title"> <?= $disciplinasIcons[$lista->getDisciplina_id_fk()]; ?> <?= $lista->getTitle(); ?></h1>
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
              <a href="post.php?post=<?= $lista->getId(); ?>"><i class="fas fa-chevron-circle-up icone-2"></i>Ver post</a>

            </div>
          </a>
    <?php endforeach; ?>
<?php endif; ?>

