<?php
  // inicia a sessão
  session_start();
   
  // obtém o array gravado na sessão
  $nomes = $_SESSION["nomess"];
 
  // obtém os valores do array
  for($i = 0; $i < count($nomes); $i++){
    echo $nomes[$i] . "<br>";
  }
?>