<?php

class PostLikes {
    private $id;
    private $id_post;
    private $id_user;
    private $created_at;

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
        $this->type = $id_post;
    }

    public function getId_user(){
        return $this->id_user;
    }
    public function setId_user($id_user){
        $this->title = $id_user;
    }
    public function getCreated_at(){
        return $this->created_at;
    }
    public function setCreated_at($created_at){
        //$created_at = date('m-d-Y h:i:s a', time());
        $this->created_at = $created_at;
    }

}

interface PostLikesDAO {
    public function add($id_post, $id_user);
}

?>