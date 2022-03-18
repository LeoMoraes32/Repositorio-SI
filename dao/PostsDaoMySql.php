<?php
require_once 'models/Posts.php';

class PostsDaoMySql implements PostsDAO {
    private $pdo;

    public function __construct(PDO $driver) {
        $this->pdo = $driver;
    }
    public function add($type, $title, $body, $created_at, $users_id_fk, $disciplina_id_fk){
        $sql = $this->pdo->prepare("INSERT INTO posts (type, title, body, created_at, users_id_fk, disciplina_id_fk) VALUES (:type, :title, :body, :created_at, :users_id_fk, :disciplina_id_fk)");
        $sql->bindValue(':type', $type);
        $sql->bindValue(':title', $title);
        $sql->bindValue(':body', $body);
        $sql->bindValue(':created_at', $created_at);
        $sql->bindValue(':users_id_fk', $users_id_fk);
        $sql->bindValue(':disciplina_id_fk', $disciplina_id_fk);
        $sql->execute();

        $posts = new Posts();
        $posts->setId($this->pdo->lastInsertId());
        $posts->setType($type);
        $posts->setTitle($title);
        $posts->setBody($body);
        $posts->setCreated_at($created_at);
        $posts->setUsers_id_fk($users_id_fk);
        $posts->setDisciplina_id_fk($disciplina_id_fk);

        return $posts;

    }

    public function findAllforUser($users_id_fk){
        $array = [];

        $sql = $this->pdo->prepare("SELECT * FROM posts WHERE users_id_fk = :users_id_fk ORDER BY id DESC");
        $sql->bindValue(':users_id_fk', $users_id_fk);
        $sql->execute();

        if($sql->rowCount() > 0){
            $data = $sql->fetchAll(PDO::FETCH_ASSOC);

            foreach($data as $item) {
                $posts = new Posts();
                $posts->setId($item['id']);
                $posts->setType($item['type']);
                $posts->setTitle($item['title']);
                $posts->setBody($item['body']);
                $posts->setCreated_at($item['created_at']);
                $posts->setUsers_id_fk($item['users_id_fk']);
                $posts->setDisciplina_id_fk($item['disciplina_id_fk']);

                $array[] = $posts;
            }
        }
        return $array;
    }

    public function findAllforDisciplinas($disciplina_id_fk){
        $array = [];

        $sql = $this->pdo->prepare("SELECT * FROM posts WHERE disciplina_id_fk = :disciplina_id_fk");
        $sql->bindValue(':disciplina_id_fk', $disciplina_id_fk);
        $sql->execute();

        if($sql->rowCount() > 0){
            $data = $sql->fetchAll();

            foreach($data as $item) {
                $posts = new Posts();
                $posts->setId($item['id']);
                $posts->setType($item['type']);
                $posts->setTitle($item['title']);
                $posts->setBody($item['body']);
                $posts->setCreated_at($item['created_at']);
                $posts->setUsers_id_fk($item['users_id_fk']);
                $posts->setDisciplina_id_fk($item['disciplina_id_fk']);

                $array[] = $posts;
            }
        }
        return $array;
    }

    public function findAllById($id){
        $array = [];

        $sql = $this->pdo->prepare("SELECT * FROM posts WHERE id = :id");
        $sql->bindValue(':id', $id);
        $sql->execute();

        if($sql->rowCount() > 0){
            $data = $sql->fetchAll();

            foreach($data as $item) {
                $posts = new Posts();
                $posts->setId($item['id']);
                $posts->setType($item['type']);
                $posts->setTitle($item['title']);
                $posts->setBody($item['body']);
                $posts->setCreated_at($item['created_at']);
                $posts->setUsers_id_fk($item['users_id_fk']);
                $posts->setDisciplina_id_fk($item['disciplina_id_fk']);

                $array[] = $posts;
            }
        }
        return $array;
    }
    

    public function findAll(){
        $array = [];

        $sql = $this->pdo->query("SELECT * FROM posts ORDER BY id DESC");
        if($sql->rowCount() > 0) {
            $data = $sql->fetchAll();

            foreach($data as $item) {
                $posts = new Posts();
                $posts->setId($item['id']);
                $posts->setType($item['type']);
                $posts->setTitle($item['title']);
                $posts->setBody($item['body']);
                $posts->setCreated_at($item['created_at']);
                $posts->setUsers_id_fk($item['users_id_fk']);
                $posts->setDisciplina_id_fk($item['disciplina_id_fk']);

                $array[] = $posts;
            }
        }
        return $array;
    }

    public function findLasThree(){
        $array = [];

        $sql = $this->pdo->query("SELECT * FROM posts ORDER BY id DESC limit 3");
        if($sql->rowCount() > 0) {
            $data = $sql->fetchAll();

            foreach($data as $item) {
                $posts = new Posts();
                $posts->setId($item['id']);
                $posts->setType($item['type']);
                $posts->setTitle($item['title']);
                $posts->setBody($item['body']);
                $posts->setCreated_at($item['created_at']);
                $posts->setUsers_id_fk($item['users_id_fk']);
                $posts->setDisciplina_id_fk($item['disciplina_id_fk']);

                $array[] = $posts;
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

            return $users;
        }else{
            return false;
        }
    }

   
    public function findById($id){
        $sql = $this->pdo->prepare("SELECT * FROM posts WHERE id = :id");
        $sql->bindValue(':id', $id);
        $sql->execute();

        if($sql->rowCount() > 0){
            $data = $sql->fetch(PDO::FETCH_ASSOC);

            $posts = new Posts();
            $posts->setId($data['id']);
            $posts->setType($data['type']);
            $posts->setTitle($data['title']);
            $posts->setBody($data['body']);
            $posts->setCreated_at($data['created_at']);
            $posts->setUsers_id_fk($data['users_id_fk']);
            $posts->setDisciplina_id_fk($data['disciplina_id_fk']);

            return $posts;
        }else{
            return false;
        }
    }

    public function update($type, $title, $body, $created_at, $users_id_fk, $disciplina_id_fk, $id){
        $sql = $this->pdo->prepare("UPDATE posts SET type = :type, title = :title, body = :body, created_at = :created_at, users_id_fk = :users_id_fk, disciplina_id_fk = :disciplina_id_fk  WHERE id = :id");
        $sql->bindValue(':type', $type);
        $sql->bindValue(':title', $title);
        $sql->bindValue(':body', $body);
        $sql->bindValue(':created_at', $created_at);
        $sql->bindValue(':users_id_fk', $users_id_fk);
        $sql->bindValue(':disciplina_id_fk', $disciplina_id_fk);
        $sql->bindValue(':id', $id);
        $sql->execute();

        return true;
    }

    public function updateVisit($id){
        $sql = $this->pdo->prepare("UPDATE posts SET visit = visit + 1 WHERE id = :id");
        $sql->bindValue(':id', $id);
        $sql->execute();

        return true;
    }

    public function findMoreVisited(){
        $sql = $this->pdo->query("SELECT * FROM posts ORDER BY visit DESC LIMIT 3");
        if($sql->rowCount() > 0) {
            $data = $sql->fetchAll();

            foreach($data as $item) {
                $posts = new Posts();
                $posts->setId($item['id']);
                $posts->setType($item['type']);
                $posts->setTitle($item['title']);
                $posts->setBody($item['body']);
                $posts->setCreated_at($item['created_at']);
                $posts->setUsers_id_fk($item['users_id_fk']);
                $posts->setDisciplina_id_fk($item['disciplina_id_fk']);

                $array[] = $posts;
            }
        }
        return $array;
    }

    public function delete($id){
        $sql = $this->pdo->prepare("DELETE FROM posts WHERE id = :id");
        $sql->bindValue(':id', $id);
        $sql->execute();
    }

    public function findLike($title){
        $array = [];

        
        $sql = $this->pdo->prepare("SELECT * FROM posts WHERE title LIKE :title OR body LIKE :title ORDER BY id DESC");
        $sql->bindValue(':title', "%$title%");
        $sql->execute();
        
        if($sql->rowCount() > 0) {
            $data = $sql->fetchAll(PDO::FETCH_ASSOC);

            foreach($data as $item) {
                $posts = new Posts();
                $posts->setId($item['id']);
                $posts->setType($item['type']);
                $posts->setTitle($item['title']);
                $posts->setBody($item['body']);
                $posts->setCreated_at($item['created_at']);
                $posts->setUsers_id_fk($item['users_id_fk']);
                $posts->setDisciplina_id_fk($item['disciplina_id_fk']);

                $array[] = $posts;
            }
        }
        return $array;
    }

    public function findLikeLimit($title){
        $array = [];

        
        $sql = $this->pdo->prepare("SELECT * FROM posts WHERE title LIKE :title OR body LIKE :title ORDER BY id DESC LIMIT 5");
        $sql->bindValue(':title', "%$title%");
        $sql->execute();
        
        if($sql->rowCount() > 0) {
            $data = $sql->fetchAll(PDO::FETCH_ASSOC);

            foreach($data as $item) {
                $posts = new Posts();
                $posts->setId($item['id']);
                $posts->setType($item['type']);
                $posts->setTitle($item['title']);
                $posts->setBody($item['body']);
                $posts->setCreated_at($item['created_at']);
                $posts->setUsers_id_fk($item['users_id_fk']);
                $posts->setDisciplina_id_fk($item['disciplina_id_fk']);

                $array[] = $posts;
            }
        }
        return $array;
    }
    
}