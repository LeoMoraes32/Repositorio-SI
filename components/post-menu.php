<nav class="navbar navbar-expand-lg navbar-light bg-white" id="mainNav">
        <div class="container px-lg-5">
            <a class="navbar-brand logo" href="index.php">Repositório <span>SI</span></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                <i class="fas fa-bars"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav mr-auto py-4 py-lg-0">
                  <li class="nav-item"><a class="nav-link verde py-3 py-lg-4" href="criar-post.php">Criar post</a></li>
                </ul>
                <ul class="navbar-nav ms-auto py-4 py-lg-0">
                 
                  
                    <li class="nav-item"><a class="nav-link verde py-3 py-lg-4" href="index.php">Home</a></li>
                    <li class="nav-item dropdown">
                        <a class="nav-link py-lg-3 dropdown-toggle verde" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-expanded="false"> 
                          <img src="<?php echo 'assets/users-img/'.$imagem?>" style="width: auto; height: 45px;" class="rounded-circle" alt="Avatar">
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                          <li><a class="dropdown-item verde" href="perfil.php?user=<?=$id;?>"><?=$name ?></a>
                          <a style="font-size: 0.75rem;" class="dropdown-item verde disabled"><?=$email;?></a>
                          </li>
                          <div class="dropdown-divider"></div>
                          <li><a class="dropdown-item verde" href="criar-post.php">Criar Post</a></li>
                          <li><a class="dropdown-item verde" href="settings.php">Configurações</a></li>
                          <div class="dropdown-divider"></div>
                          <li><a class="dropdown-item verde" href="sair.php">Sair</a></li>
                        </ul>
                      </li>
                    
                </ul>
            </div>
        </div>
    </nav>