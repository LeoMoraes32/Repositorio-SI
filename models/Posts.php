<?php

class Posts {
    private $id;
    private $type;
    private $title;
    private $body;
    private $created_at;
    private $users_id_fk;
    private $disciplina_id_fk;
    private $visit;

    public function getId(){
        return $this->id;
    }
    public function setId($id){
        $this->id = trim($id);
    }

    public function getType(){
        return $this->type;
    }
    public function setType($type){
        $this->type = ucwords(trim($type));
    }

    public function getTitle(){
        return $this->title;
    }
    public function setTitle($title){
        $this->title = $title;
    }

    public function getBody(){
        return $this->body;
    }
    public function setBody($body){
        $this->body = $body;
    }

    public function getCreated_at(){
        return $this->created_at;
    }
    public function setCreated_at($created_at){
        //$created_at = date('m-d-Y h:i:s a', time());
        $this->created_at = $created_at;
    }

    public function getUsers_id_fk(){
        return $this->users_id_fk;
    }
    public function setUsers_id_fk($users_id_fk){
        $this->users_id_fk = $users_id_fk;
    }

    public function getDisciplina_id_fk(){
        return $this->disciplina_id_fk;
    }

    public function setDisciplina_id_fk($disciplina_id_fk){
        $this->disciplina_id_fk = $disciplina_id_fk;
    }

    public function getVisit(){
        return $this->visit;
    }

    public function setVisit($visit){
        $this->visit = $visit;
    }
}

interface PostsDAO {
    public function add($type, $title, $body, $created_at, $users_id_fk, $disciplina_id_fk);
    public function findAllforUser($users_id_fk);
    public function findAll();
    public function findById($id);
    public function update($id, $type, $title, $mytextarea, $datetime, $users_id_fk, $disciplina_id_fk);
    public function updateVisit($id);
    public function findMoreVisited();
    public function delete($id);
}

?>