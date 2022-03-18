<?php
require_once 'models/Arquivos.php';

class ArquivosDaoMySql implements ArquivosDAO {
    private $pdo;

    public function __construct(PDO $driver){
        $this->pdo = $driver;
    }
    public function add($arquivo, $id_post_fk){
        $sql = $this->pdo->prepare("INSERT INTO arquivos_publicacao (arquivo, id_post_fk) VALUES (:arquivo, :id_post_fk)");
        $sql->bindValue(':arquivo',$arquivo);
        $sql->bindValue(':id_post_fk',$id_post_fk);
        $sql->execute();

        $arquivos = new Arquivos();
        $arquivos->setId($this->pdo->lastInsertId());
        $arquivos->setArquivo($arquivo);
        $arquivos->setId_post_fk($id_post_fk);

        return $arquivos;
    }

    public function update($arquivo, $id_post_fk){
        $sql = $this->pdo->prepare("UPDATE arquivos_publicacao SET arquivo = :arquivo WHERE id_post_fk = :id_post_fk");
        $sql->bindValue(':arquivo',$arquivo);
        $sql->bindValue(':id_post_fk', $id_post_fk);
        $sql->execute();

        return true;
    }
}