<?php
require 'config.php';
require 'dao/PostsDaoMySql.php';
require 'dao/TagsDaoMySql.php';
require 'dao/ArquivosDaoMySql.php';

session_start();
$id = $_SESSION['id'];

$postsDao = new PostsDaoMySql($pdo);
$tagsDao = new TagsDaoMySql($pdo);
$arquivosDao = new ArquivosDaoMySql($pdo);

if(isset($_POST['enviar'])){
    $titulo = filter_input(INPUT_POST, 'tituloPost');
    $tag = filter_input(INPUT_POST, 'tags');
    $mytextarea = filter_input(INPUT_POST, 'mytextarea');
    $disciplina_id_fk = filter_input(INPUT_POST, 'disciplina');
    $arquivo = $_FILES['arquivo'];
    $type='pdf';
    $datetime = date_create();
    $posts = $postsDao->add($type, $titulo, $mytextarea, $datetime->format('Y-m-d'),$id ,$disciplina_id_fk);

    $arrayTags = explode(',',$tag);
    $count = count($arrayTags);
    for ($i = 0; $i < $count; $i++){
        $tags = $tagsDao->add($arrayTags[$i],$posts->getId());
    }
    preg_match_all('/<img [^>]*src=["|\']([^"|\']+)/i', $mytextarea, $matches);
    $arrayImages = [];
    $f = 0;
    foreach ($matches[1] as $key=>$value) {
        $arrayImages[$f]=$value;
        $f++;
    }
    for($i = 0; $i < count($arrayImages); $i++){
        $arquivos = $arquivosDao->add($arrayImages[$i], $posts->getId());
    }
    echo '<hr>';
    print_r($_FILES['arquivo']['name'][0]);
    echo '<br>';
    print_r($_FILES['arquivo']['tmp_name']);
    echo '<hr>';
    $contagem = count($_FILES['arquivo']['name']);
    if($_FILES['arquivo']['size'] > 0){
        for($i = 0; $i < $contagem; $i++){
            $nome = $_FILES['arquivo']['name'][$i];
            $locationArquivo = 'assets/posts/'.$id.'/'.$id.'_'.$nome;
            move_uploaded_file($_FILES['arquivo']['tmp_name'][$i], $locationArquivo);
        }
    }

    print_r($arrayImages);




}