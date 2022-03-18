<?php 

require 'config.php';
require 'dao/UsersDaoMySql.php';
require 'dao/PostsDaoMySql.php';
require 'components/disciplinas-icons.php';
require 'dao/TagsDaoMySql.php';

$busca = filter_input(INPUT_GET, 'term', FILTER_SANITIZE_STRING);

$postsDao = new PostsDaoMySql($pdo);
$posts = $postsDao->findLikeLimit($busca);

foreach($posts as $listas){
    $data[] = $listas['body'];
}

echo json_encode($data);


?>
