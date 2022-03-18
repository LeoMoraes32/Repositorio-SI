<?php
require 'config.php';
require 'dao/PostsDaoMySql.php';
session_start();
$id = $_SESSION['id'];

$postsDao = new PostsDaoMySql($pdo);

if (isset($_POST['post'])) {

    $tituloPost = filter_input(INPUT_POST, 'tituloPost');
    $tags = filter_input(INPUT_POST, 'tags');
    $mytextarea = filter_input(INPUT_POST, 'mytextarea');
    $disciplina_id_fk = filter_input(INPUT_POST,'disciplina');
    $arquivo = $_FILES['arquivo'];
    //$nomes = $arquivo['name'];
    $tamanho = count($_FILES['arquivo']);
    if($tamanho > 0){
        for($i = 0; $i < $tamanho-1; $i++){
            $nome = $_FILES['arquivo']['name'][$i];
            move_uploaded_file($_FILES['arquivo']['tmp_name'][$i], 'assets/posts/'.$id.'/'.$id.'_'.$nome);
        }
            
    }


    var_dump($tituloPost);
    echo '<br>';
    var_dump($tags);
    echo '<br>';
    var_dump($mytextarea);
    //mkdir('assets/posts/teste1', 0777, true);
    
    $id = $_SESSION['id'];
    echo '<br>';
    echo "<pre>";
    $certo = $_SESSION['fotos'][2];
    print_r($_SESSION['fotos'][1]);
    print_r($_SESSION['fotos'][2]);
    echo '<br>';
    echo '------';
    echo '<br>';
    echo 'Printando as SESSION FOTOS';
    echo '<br>';
    echo '<hr>';
    preg_match_all('/<img [^>]*src=["|\']([^"|\']+)/i', $mytextarea, $matches);
    foreach ($matches[1] as $key=>$value) {
        echo PHP_EOL . $value;
        echo '<br>';
    }
    echo '<hr>';
    echo '<br>';
    echo 'acabou o print de SESSION FOTOS';
    echo '<br>';
    print_r($id.'_'.$certo[0]['file']['name']);
    echo '<br>';
    echo '------';
    print_r($_SESSION['pageCount']);
    $_SESSION['pageCount'] = 0;
    
    $type = 'pdf';
    $date = new DateTime();
    echo '<br>';
    $datetime = date_create()->format('Y-m-d');
    echo $datetime;
    echo '<br>';
    echo $disciplina_id_fk;
    echo '<br>';
    $arrayTags = explode(',',$tags);
    echo $arrayTags[0];
    //$posts = $postsDao->add($type, $tituloPost, $mytextarea, $datetime, $id, $disciplina_id_fk);
    var_dump($posts);
    echo '<hr>';
    echo '<br>';
    echo $arquivo; 


}
?>