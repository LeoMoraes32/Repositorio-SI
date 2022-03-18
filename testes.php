<?php
 // inicia a sessão
  session_start();
   
  // cria um array de nomes
  $nomes = array("Osmar", "Cristina", "Cecília");
 
  // coloca o array na sessão
  $_SESSION["nomess"] = $nomes;
   
  echo "Acesse testes2.php para obter os dados gravados.";
?>