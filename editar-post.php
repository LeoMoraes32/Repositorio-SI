<?php

require 'config.php';
require 'dao/UsersDaoMySql.php';

require 'dao/PostsDaoMySql.php';
require 'dao/TagsDaoMySql.php';
require 'dao/ArquivosDaoMySql.php';

require 'components/disciplinas-icons.php';

$usersDao = new UsersDaoMysql($pdo);
$error = false;
$sucesso = false;
$lista = $usersDao->findAll();

$postsDao = new PostsDaoMySql($pdo);
$tagsDao = new TagsDaoMySql($pdo);
$arquivosDao = new ArquivosDaoMySql($pdo);

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

$idpublicacao = $_GET['id'];
$post = $postsDao->findById($idpublicacao);
$tags = $tagsDao->findById($idpublicacao);
$Stag = '';
for($i=0;$i<sizeof($tags);$i++){
    $Stag = $Stag.$tags[$i]->getTag().',';
}
$disciplina = $post->getDisciplina_id_fk();


if (isset($_POST['enviar'])) {
    $titulo = filter_input(INPUT_POST, 'tituloPost');
    $tag = filter_input(INPUT_POST, 'tags');
    $mytextarea = filter_input(INPUT_POST, 'mytextarea');
    $disciplina_id_fk = filter_input(INPUT_POST, 'disciplina');
    $arquivo = $_FILES['arquivo'];
    $type = 'pdf';
    $datetime = date_create();


    $mytextarea = $mytextarea."<span style='display=none'><?=#$tag?></span>";
    $mytextarea = $mytextarea."<span style='display=none'><?=$name?></span>";

    $posts = $postsDao->update($type, $titulo, $mytextarea, $datetime->format('Y-m-d'), $id, $disciplina_id_fk, $idpublicacao);
    
    $arrayTags = explode(',', $tag);
    $count = count($arrayTags);

    $tagsDao->delete($idpublicacao);
    for ($i = 0; $i < $count; $i++) {
        $tags = $tagsDao->add($arrayTags[$i], $idpublicacao);
        $Stag = $Stag.','.$arrayTags[$i];
    }
    preg_match_all('/<img [^>]*src=["|\']([^"|\']+)/i', $mytextarea, $matches);
    $arrayImages = [];
    $f = 0;
    foreach ($matches[1] as $key => $value) {
        $arrayImages[$f] = $value;
        $f++;
    }
    for ($i = 0; $i < count($arrayImages); $i++) {
        $arquivos = $arquivosDao->update($arrayImages[$i], $idpublicacao);
    }
    $contagem = count($_FILES['arquivo']['name']);
    if ($_FILES['arquivo']['size'] > 0) {
        for ($i = 0; $i < $contagem; $i++) {
            $nome = $_FILES['arquivo']['name'][$i];
            $locationArquivo = 'assets/posts/' . $id . '/' . $id . '_' . $nome;
            move_uploaded_file($_FILES['arquivo']['tmp_name'][$i], $locationArquivo);
        }
    }
    $sucesso = true;
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
    <link rel="stylesheet" href="assets/css/bootstrap-tagsinput.css">

    <script src="assets/tinymce/tinymce.min.js" referrerpolicy="origin"></script>


    <link href="styles.css" rel="stylesheet" />
    <link rel="sortcut icon" href="https://img.elo7.com.br/product/main/347C7D8/matriz-sistema-de-informacao-sistema-de-informacao.jpg" type="image/jpg" />
    <title>Repositório S.I</title>
</head>

<body>
    <!-- Navigation -->
    <?php
    require('./components/post-menu.php');
    ?>
    <section class="container-fluid color">

        <div class="container py-4">
            <div class="card">
                <div class="card-body">
                    <?php
                    if ($sucesso) {
                        echo '
                            <div class="alert alert-success" role="alert">
                                Postagem editada com sucesso!
                            </div>
                            ';
                    }
                    ?>
                    <form method="POST" id="post" action="" enctype="multipart/form-data">
                        <div class="form-group">
                            <label class="form-label labels">Título*</label>
                            <input value="<?=$post->getTitle()?>" type="text" class="form-control" name="tituloPost" id="tituloPost" autocomplete="off" aria-describedby="titleHelps" maxlength="100" placeholder="Novo título da postagem aqui..." required />
                            <small id="titleHelp" class="form-text text-muted "><i class="fas fa-angle-right"></i>
                                Pense no título da sua postagem como uma descrição super curta (mas convincente!) - como uma visão geral da postagem real em uma frase curta.
                                Use palavras-chave quando apropriado para ajudar a garantir que as pessoas possam encontrar sua postagem por meio de pesquisa.</small>
                        </div>
                        <div class="form-group">
                            <label class="form-label labels">Tags*</label>
                            <input value="<?=$Stag?>" type="text" class="form-control" name="tags" id="tags" autocomplete="off" aria-describedby="tagsHelps" placeholder="SI2, PDS2, AED2" data-role="tagsinput" required />
                            <small name="tagsHelps" id="tagsHelps" class="form-text text-muted "><i class="fas fa-angle-right"></i>
                                Digite sua tag e aperte enter para separa-la.
                                As tags ajudam as pessoas a encontrar sua postagem.
                                Pense em tags como os tópicos ou categorias que melhor descrevem sua postagem.</small>
                        </div>

                        <div class="form-group">
                            <label class="form-label labels">Disciplina*</label>
                            <select required name="disciplina" id="disciplina" style="border: 1px solid #ced4da; border-radius:0.25rem; width:100%; padding: 0.375rem 0.75rem;" aria-describedby="disciplinaHelps">
                                <optgroup label="1° Periodo">
                                    <?php if($disciplina == 1): ?>
                                    <option selected value="1">Sistemas para Internet I</option>
                                    <?php else: ?>
                                        <option value="1">Sistemas para Internet I</option>
                                    <?php endif; ?>

                                    <?php if($disciplina == 2): ?>
                                    <option selected value="2">Algoritmos e Estruturas de Dados I</option>
                                    <?php else: ?>
                                        <option value="2">Algoritmos e Estruturas de Dados I</option>
                                    <?php endif; ?>

                                    <?php if($disciplina == 3): ?>
                                    <option selected value="3">Atividade de Integração Curricular I</option>
                                    <?php else: ?>
                                        <option value="3">Atividade de Integração Curricular I</option>
                                    <?php endif; ?>

                                    <?php if($disciplina == 4): ?>
                                    <option selected value="4">Matemática Discreta</option>
                                    <?php else: ?>
                                        <option value="4">Matemática Discreta</option>
                                    <?php endif; ?>
                                    
                                    <?php if($disciplina == 5): ?>
                                    <option selected value="5">Matemática I</option>
                                    <?php else: ?>
                                        <option value="5">Matemática I</option>
                                    <?php endif; ?>
                                    
                                    <?php if($disciplina == 6): ?>
                                    <option selected value="6">Matemática II</option>
                                    <?php else: ?>
                                        <option value="6">Matemática II</option>
                                    <?php endif; ?>
                                    

                                    <?php if($disciplina == 7): ?>
                                    <option selected value="7">Economia</option>
                                    <?php else: ?>
                                        <option  value="7">Economia</option>
                                    <?php endif; ?>
                                    
                                    <?php if($disciplina == 8): ?>
                                    <option selected value="8">Teoria Geral da Administração</option>
                                    <?php else: ?>
                                        <option  value="8">Teoria Geral da Administração</option>
                                    <?php endif; ?>
                                    
                                    <?php if($disciplina == 9): ?>
                                    <option selected value="9">Fundamentos de Administração</option>
                                    <?php else: ?>
                                        <option value="9">Fundamentos de Administração</option>
                                    <?php endif; ?>
                                </optgroup>
                                <optgroup label="2° Periodo">
                                    <?php if($disciplina == 10): ?>
                                    <option selected value="10">Linguagens Formais e Autômatos</option>
                                    <?php else: ?>
                                        <option value="10">Linguagens Formais e Autômatos</option> 
                                    <?php endif; ?>
                                    
                                    <?php if($disciplina == 11): ?>
                                    <option selected value="11">Sistemas Corporativos I</option>
                                    <?php else: ?>
                                        <option value="11">Sistemas Corporativos I</option>
                                    <?php endif; ?>
                                    
                                    <?php if($disciplina == 12): ?>
                                    <option selected value="12">Algoritmos e Estruturas de Dados II</option>
                                    <?php else: ?>
                                        <option value="12">Algoritmos e Estruturas de Dados II</option>
                                    <?php endif; ?>
                                    
                                    <?php if($disciplina == 13): ?>
                                    <option selected value="13">Atividade de Integração Curricular II</option>
                                    <?php else: ?>
                                        <option  value="13">Atividade de Integração Curricular II</option>
                                    <?php endif; ?>

                                    <?php if($disciplina == 14): ?>
                                    <option selected value="14">Gestão da Informação nas Organizações</option>
                                        <?php else: ?>
                                            <option  value="14">Gestão da Informação nas Organizações</option>
                                    <?php endif; ?>
                                    
                                    <?php if($disciplina == 15): ?>
                                    <option selected value="15">Interface Humano-Computador</option>
                                    <?php else: ?>
                                        <option  value="15">Interface Humano-Computador</option>
                                    <?php endif; ?>
                                    
                                    <?php if($disciplina == 16): ?>
                                    <option selected value="16">Elementos de Custos</option>
                                    <?php else: ?>
                                        <option  value="16">Elementos de Custos</option>
                                    <?php endif; ?>
                                    
                                    <?php if($disciplina == 17): ?>
                                    <option selected value="17">Arquitetura de Computadores</option>
                                    <?php else: ?>
                                        <option  value="17">Arquitetura de Computadores</option>
                                    <?php endif; ?>
                                    
                                    <?php if($disciplina == 18): ?>
                                    <option selected value="18">Organização de Computadores</option>
                                    <?php else: ?>
                                        <option  value="18">Organização de Computadores</option>
                                    <?php endif; ?>
                                    
                                    <?php if($disciplina == 19): ?>
                                    <option selected value="19">Linguagens de Programação</option>
                                    <?php else: ?>
                                        <option  value="19">Linguagens de Programação</option>
                                    <?php endif; ?>
                                </optgroup>
                                <optgroup label="3° Periodo">
                                    <?php if($disciplina == 20): ?>
                                    <option selected value="20">Projeto e Desenvolvimento de Software I</option>
                                    <?php else: ?>
                                        <option  value="20">Projeto e Desenvolvimento de Software I</option>
                                    <?php endif; ?>
                                    
                                    <?php if($disciplina == 21): ?>
                                    <option selected value="21">Sistemas Corporativos II</option>
                                    <?php else: ?>
                                        <option  value="21">Sistemas Corporativos II</option>
                                    <?php endif; ?>
                                    
                                    <?php if($disciplina == 22): ?>
                                    <option selected value="22">Sistemas Operacionais</option>
                                    <?php else: ?>
                                        <option  value="22">Sistemas Operacionais</option>
                                    <?php endif; ?>
                                    
                                    <?php if($disciplina == 23): ?>
                                    <option selected value="23">Sistemas para Internet II</option>
                                    <?php else: ?>
                                        <option  value="23">Sistemas para Internet II</option>
                                    <?php endif; ?>
                                    
                                    <?php if($disciplina == 24): ?>
                                    <option selected value="24">Atividade de Integração Curricular III</option>
                                    <?php else: ?>
                                        <option value="24">Atividade de Integração Curricular III</option>
                                    <?php endif; ?>
                                    
                                    <?php if($disciplina == 25): ?>
                                    <option selected value="25">Probabilidade e Estatística Aplicada à Engenharia</option>
                                    <?php else: ?>
                                        <option  value="25">Probabilidade e Estatística Aplicada à Engenharia</option>
                                    <?php endif; ?>
                                    
                                    <?php if($disciplina == 26): ?>
                                    <option selected value="26">Direito e Legislação</option>
                                    <?php else: ?>
                                        <option  value="26">Direito e Legislação</option>
                                    <?php endif; ?>
                                    
                                    <?php if($disciplina == 27): ?>
                                    <option selected value="27">Redes de Computadores</option>
                                    <?php else: ?>
                                        <option  value="27">Redes de Computadores</option>
                                    <?php endif; ?>
                                    
                                    <?php if($disciplina == 28): ?>
                                    <option selected value="28">Planejamento e Gestão de Projetos</option>
                                    <?php else: ?>
                                        <option  value="28">Planejamento e Gestão de Projetos</option>
                                    <?php endif; ?>
                                    
                                    <?php if($disciplina == 29): ?>
                                    <option selected value="29">Sistemas Gerenciadores de Bancos de Dados</option>
                                    <?php else: ?>
                                        <option  value="29">Sistemas Gerenciadores de Bancos de Dados</option>
                                    <?php endif; ?>
                                </optgroup>
                                <optgroup label="4° Periodo">
                                    <?php if($disciplina == 30): ?>
                                    <option selected value="30">Estágio Supervisionado em Sistemas de Informação</option>
                                    <?php else: ?>
                                        <option  value="30">Estágio Supervisionado em Sistemas de Informação</option>
                                    <?php endif; ?>

                                    <?php if($disciplina == 31): ?>
                                    <option selected value="31">Projeto e Desenvolvimento de Software II</option>
                                    <?php else: ?>
                                        <option  value="31">Projeto e Desenvolvimento de Software II</option>
                                    <?php endif; ?>

                                    <?php if($disciplina == 32): ?>
                                    <option selected value="32">Projeto de Graduação em Sistemas de Informação</option>
                                    <?php else: ?>
                                        <option  value="32">Projeto de Graduação em Sistemas de Informação</option>
                                    <?php endif; ?>

                                    <?php if($disciplina == 33): ?>
                                    <option selected value="33">Gerenciamento de Empresas</option>
                                    <?php else: ?>
                                        <option  value="33">Gerenciamento de Empresas</option>
                                    <?php endif; ?>
                                </optgroup>
                                <optgroup label="Sem relação">
                                    <?php if($disciplina == 34): ?>
                                    <option selected value="34">Outros</option>
                                    <?php else: ?>
                                        <option  value="34">Outros</option>
                                    <?php endif; ?>

                                    <?php if($disciplina == 35): ?>
                                    <option selected value="35">Extras</option>
                                    <?php else: ?>
                                        <option value="35">Extras</option>
                                    <?php endif; ?>
                                    <option value="36"></option>
                                </optgroup>
                            </select>
                            <small id="disciplinaHelps" class="form-text text-muted"><i class="fas fa-angle-right"></i>
                                Adicione uma categoria para ajudar na classficação da postagem, encontre a disciplina associada a sua postagem ou use e abuse do campo outros e extras
                            </small>
                        </div>
                        <div class="form-group">
                            <label class="form-label labels">Post*</label>
                            <small required id="postHelp" class="form-text text-muted"><i class="fas fa-angle-right"></i>
                                Crie aqui sua postagem, inserindo imagens e editando seu texto da forma que preferir!</small>
                            <textarea id="mytextarea" name="mytextarea"><?=$post->getBody();?></textarea>

                        </div>
                        <div class="form-group">
                            <label class="form-label labels">Arquivos(PDF, zips...)</label>
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" name="arquivo[]" id="arquivo" multiple>
                                </div>
                                <div class="input-group-append">
                                </div>
                            </div>
                            <small id="custom" class="form-text text-muted"><i class="fas fa-angle-right"></i>
                                Para enviar mais de um arquivo selecione mais de um.
                            </small>
                        </div>
                        <div class="col text-center my-3">
                            <button name="enviar" type="submit" class="btn btn-success">Salvar</button>
                            <p>Por favor, preencha os campos obrigatórios marcados com <b>(*)</b></p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <?php
    require('./components/footer.php');
    ?>

    <script type="text/javascript" src="assets/js/jquery-3.6.0.min.js"></script>
    <script type="text/javascript" src="assets/js/bootstrap.bundle.min.js"></script>
    <!--<script type="text/javascript" src="assets/js/bootstrap.min.js"></script>
-->
    <script src="assets/js/script.js"></script>
    <script type="text/javascript" src="assets/js/bootstrap-tagsinput.min.js"></script>

    <script>
        $(window).ready(function() {
            $("#post").on("keypress", function(event) {
                var keyPressed = event.keyCode || event.which;
                if (keyPressed === 13) {
                    event.preventDefault();
                    return false;
                }
            });
        });
        tinymce.init({
            selector: '#mytextarea',
            height: 300,
            plugins: [
                'advlist autolink lists link image charmap print preview anchor',
                'searchreplace visualblocks code fullscreen',
                'insertdatetime media table paste imagetools wordcount'
            ],
            toolbar: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',

            // without images_upload_url set, Upload tab won't show up
            images_upload_url: 'upload.php',

            // override default upload handler to simulate successful upload
            images_upload_handler: function(blobInfo, success, failure) {
                var xhr, formData;

                xhr = new XMLHttpRequest();
                xhr.withCredentials = false;
                xhr.open('POST', 'upload.php');

                xhr.onload = function() {
                    var json;

                    if (xhr.status != 200) {
                        failure('HTTP Error: ' + xhr.status + ' - Nome do arquivo inválido.');
                        return;
                    }

                    json = JSON.parse(xhr.responseText);

                    if (!json || typeof json.location != 'string') {
                        failure('Invalid JSON: ' + xhr.responseText);
                        return;
                    }

                    success(json.location);
                };

                formData = new FormData();
                formData.append('file', blobInfo.blob(), blobInfo.filename());

                xhr.send(formData);
            },
        });
    </script>


</body>

</html>