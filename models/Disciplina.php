<?php

class Disciplina {
    private $id;
    private $nome;
    private $ano;
    private $carga;
    private $curso;
    private $ementa;
    private $qtd_posts;

    public function getId(){
        return $this->id;
    }
    public function setId($id){
        $this->id = trim($id);
    }

    public function getNome(){
        return $this->nome;
    }
    public function setNome($nome){
        $this->nome = $nome;
    }

    public function getAno(){
        return $this->ano;
    }
    public function setAno($ano){
        $this->ano = $ano;
    }

    public function getCarga(){
        return $this->carga;
    }
    public function setCarga($carga){
        $this->carga = $carga;
    }
    public function getCurso(){
        return $this->curso;
    }
    public function setCurso($curso){
        $this->curso = $curso;
    }
    public function getEmenta(){
        return $this->ementa;
    }
    public function setEmenta($ementa){
        $this->ementa = $ementa;
    }
    public function getQtd_posts(){
        return $this->qtd_posts;
    }
    public function setQtd_posts($qtd_posts){
        $this->qtd_posts = $qtd_posts;
    }
}

interface DisciplinaDAO{
    public function findById($id);
}
?>