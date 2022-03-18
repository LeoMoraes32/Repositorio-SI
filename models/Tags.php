<?php

class Tags {
    private $tag;
    private $id_post_fk;

    public function getTag(){
        return $this->tag;
    }
    
    public function setTag($tag){
        $this->tag = $tag;
    }

    public function getId_post_fk(){
        return $this->id_post_fk;
    }

    public function setId_post_fk($id_post_fk){
        $this->id_post_fk = $id_post_fk;
    }
}

interface TagsDAO {
    public function add($tag, $id_post_fk);
    public function findById($id_post_fk);
}