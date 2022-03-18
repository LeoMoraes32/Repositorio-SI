<?php 

require 'config.php';
require 'dao/UsersDaoMySql.php';
require 'dao/PostsDaoMySql.php';
require 'dao/TagsDaoMySql.php';
require 'dao/DisciplinasDaoMySql.php';
require 'dao/PostLikesDaoMySql.php';

$usersDao = new UsersDaoMysql($pdo);
$postsDao = new PostsDaoMySql($pdo);
$tagsDao = new TagsDaoMySql($pdo);
$disciplinasDao = new DisciplinasDaoMySql($pdo);
$postLikesDao = new PostLikesDaoMySql($pdo);


$postId = $_GET['id'];

$postagens = $postsDao->delete($postId);

echo $postagens;

echo $postId;




?>