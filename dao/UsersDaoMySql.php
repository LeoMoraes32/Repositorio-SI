<?php
require_once 'models/Users.php';

class UsersDaoMysql implements UsersDAO {
    private $pdo;

    public function __construct(PDO $driver) {
        $this->pdo = $driver;
    }
    public function add($email, $password, $name, $tipo){
        
        $sql = $this->pdo->prepare("INSERT INTO users (email, password, name, tipo) VALUES (:email, :password, :name, :tipo)");
        $sql->bindValue(':email', $email);
        $sql->bindValue(':password', $password);
        $sql->bindValue(':name', $name);
      
        $sql->bindValue(':tipo', $tipo);
    
        $sql->execute();

        $users = new Users();
        $users->setId($this->pdo->lastInsertId());
        $users->setEmail($email);
        $users->setName($name);
        $users->setPassword($password);
      
        $users->setTipo($tipo);
  

        return $users;
    }

    public function findAll(){
        $array = [];

        $sql = $this->pdo->query("SELECT * FROM users");
        if($sql->rowCount() > 0) {
            $data = $sql->fetchAll();

            foreach($data as $item) {
                $users = new Users();
                $users->setId($item['id']);
                $users->setName($item['name']);
                $users->setEmail($item['email']);

                $array[] = $users;
            }
        }
        return $array;
    }

    public function findByEmail($email){
        $sql = $this->pdo->prepare("SELECT * FROM users WHERE email = :email");
        $sql->bindValue(':email', $email);
        $sql->execute();

        if($sql->rowCount() > 0){
            $data = $sql->fetch(PDO::FETCH_ASSOC);

            $users = new Users();
            $users->setId($data['id']);
            $users->setName($data['name']);
            $users->setEmail($data['email']);
            $users->setPassword($data['password']);
            $users->setAno_ingresso($data['ano_ingresso']);
            $users->setImagem($data['imagem']);
            $users->setCover($data['cover']);

            return $users;
        }else{
            return false;
        }
    }

    public function findByEmailAndPassword($email, $password){
        $sql = $this->pdo->prepare("SELECT * FROM users WHERE email = :email AND password = :password");
        $sql->bindParam(':email', $email);
        $sql->bindParam(':password', $password);
        $sql->execute();

        if($sql->rowCount() > 0){
            $data = $sql->fetch(PDO::FETCH_ASSOC);
            
            $users = new Users();
            $users->setId($data['id']);
            $users->setName($data['name']);
            $users->setEmail($data['email']);
            $users->setPassword($data['password']);
            $users->setAno_ingresso($data['ano_ingresso']);
            $users->setTipo($data['tipo']);
            $users->setImagem($data['imagem']);
            $users->setCover($data['cover']);

            return $users;
        }else{
            return false;
        }
    }

    public function findById($id){
        $sql = $this->pdo->prepare("SELECT * FROM users WHERE id = :id");
        $sql->bindValue(':id', $id);
        $sql->execute();

        if($sql->rowCount() > 0){
            $data = $sql->fetch(PDO::FETCH_ASSOC);

            $users = new Users();
            $users->setId($data['id']);
            $users->setName($data['name']);
            $users->setEmail($data['email']);
            $users->setPassword($data['password']);
            $users->setAno_ingresso($data['ano_ingresso']);
            $users->setTipo($data['tipo']);
            $users->setImagem($data['imagem']);
            $users->setCover($data['cover']);

            return $users;
        }else{
            return false;
        }
    }

    public function findLike($title){
        $array = [];
        $sql = $this->pdo->prepare("SELECT * FROM users WHERE name LIKE :title OR email LIKE :title ORDER BY id DESC");
        $sql->bindValue(':title', '%'.$title.'%');
        $sql->execute();
        
        if($sql->rowCount() > 0) {
            $data = $sql->fetchAll(PDO::FETCH_ASSOC);

            foreach($data as $item) {
                $users = new Users();
                $users->setId($item['id']);
                $users->setEmail($item['email']);
                $users->setPassword($item['password']);
                $users->setName($item['name']);
                $users->setAno_ingresso($item['ano_ingresso']);
                $users->setTipo($item['tipo']);
                $users->setImagem($item['imagem']);
                $users->setCover($item['cover']);

                $array[] = $users;
            }
        }
        return $array;
    }

    public function update(Users $users){
        $sql = $this->pdo->prepare("UPDATE users SET name = :name, email = :email, password = :password, ano_ingresso = :ano_ingresso, tipo = :tipo, imagem = :imagem, cover = :cover WHERE id = :id");
        $sql->bindValue(':name', $users->getName());
        $sql->bindValue(':email', $users->getEmail());
        $sql->bindValue(':password', $users->getPassword());
        $sql->bindValue(':ano_ingresso', $users->getAno_ingresso());
        $sql->bindValue(':tipo', $users->getTipo());
        $sql->bindValue(':imagem', $users->getImagem());
        $sql->bindValue(':cover', $users->getCover());
        $sql->bindValue(':id', $users->getId());
        $sql->execute();

        return true;
    }

    public function delete($id){
        $sql = $this->pdo->prepare("DELETE FROM users WHERE id = :id");
        $sql->bindValue(':id', $id);
        $sql->execute();
    }
}