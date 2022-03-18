<?php

class Users {
    private $id;
    private $email;
    private $password;
    private $name;
    private $ano_ingresso;
    private $tipo;
    private $imagem;
    private $cover;
    private $token;
    
    public function getId(){
        return $this->id;
    }
    public function setId($id){
        $this->id = trim($id);
    }

    public function getName(){
        return $this->name;
    }
    public function setName($name){
        $this->name = ucwords(trim($name));
    }

    public function getEmail(){
        return $this->email;
    }
    public function setEmail($email){
        $this->email = strtolower(trim($email));
    }

    public function getPassword(){
        return $this->password;
    }
    public function setPassword($password){
        $this->password = $password;
    }

    public function getAno_ingresso(){
        return $this->ano_ingresso;
    }
    public function setAno_ingresso($ano_ingresso){
        $this->ano_ingresso = $ano_ingresso;
    }

    public function getTipo(){
        return $this->tipo;
    }
    public function setTipo($tipo){
        $this->tipo = $tipo;
    }

    public function getImagem(){
        return $this->imagem;
    }
    public function setImagem($imagem){
        $this->imagem = $imagem;
    }

    public function getCover(){
        return $this-> cover;
    }
    public function setCover($cover){
        $this->cover = $cover;
    }

    public function getToken(){
        return $this->token;
    }
    public function setToken($token){
        $this->token = $token;
    }
}

interface UsersDAO {
    public function add($email, $password, $name, $tipo);
    public function findAll();
    public function findByEmail($email);
    public function findByEmailAndPassword($email, $password);
    public function findById($id);
    public function update(Users $users);
    public function delete($id);
}

?>