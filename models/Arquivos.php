<?php

class Arquivos {
    private $id;
    private $arquivo;
    private $id_post_fk;

    public function getId(){
        return $this->id;
    }
    public function setId($id){
        $this->id = trim($id);
    }
    public function getArquivo(){
        return $this->arquivo;
    }
    public function setArquivo($arquivo){
        $this->arquivo = $arquivo;
    }
    public function getId_post_fk(){
        return $this->id_post_fk;
    }
    public function setId_post_fk($id_post_fk){
        $this->id_post_fk = $id_post_fk;
    }
}

interface ArquivosDAO {
    public function add($arquivo, $id_post_fk);
}