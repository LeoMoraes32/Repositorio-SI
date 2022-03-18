<?php

$db_name = 'si_repositorio';
$db_host = 'localhost';
$db_user = 'root';
$db_pass = '';
 
$pdo = new PDO("mysql:dbname=".$db_name.";host=".$db_host, $db_user, $db_pass);

//$sql = $pdo->query('SELECT * FROM posts');

//$dados = $sql->fetchAll(PDO::FETCH_ASSOC );

//echo '<pre>';
//print_r($dados);
