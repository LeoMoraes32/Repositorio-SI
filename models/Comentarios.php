<?php

class Comentarios {
    private $id;
    private $id_post;
    private $id_user;
    private $created_at;
    private $body;

    public function getId(){
        return $this->id;
    }
    public function setId($id){
        $this->id = trim($id);
    }

    public function getId_post(){
        return $this->id_post;
    }
    public function setId_post($id_post){
        $this->id_post = $id_post;
    }

    public function getId_user(){
        return $this->id_user;
    }
    public function setId_user($id_user){
        $this->id_user = $id_user;
    }

    public function getCreated_at(){
        return $this->created_at;
    }
    public function setCreated_at($created_at){
        $this->created_at = $created_at;
    }
    public function getBody(){
        return $this->body;
    }
    public function setBody($body){
        $this->body = $body;
    }
    
}

interface ComentariosDAO {
    public function add($id_post, $id_user, $created_at, $body);
}
?>