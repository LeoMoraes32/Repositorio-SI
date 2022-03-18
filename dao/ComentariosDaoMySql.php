<?php
require_once 'models/Comentarios.php';

class ComentariosDaoMySql implements ComentariosDAO {
    private $pdo;

    public function __construct(PDO $driver) {
        $this->pdo = $driver;
    }

    public function add($id_post, $id_user, $created_at, $body){
        $sql = $this->pdo->prepare("INSERT INTO comments (id_post, id_user, created_at, body) VALUES(:id_post, :id_user, :created_at, :body)");
        $sql->bindValue(':id_post', $id_post);
        $sql->bindValue(':id_user', $id_user);
        $sql->bindValue(':created_at', $created_at);
        $sql->bindValue(':body', $body);
        $sql->execute();

        $comentarios = new Comentarios();
        $comentarios->setId($this->pdo->lastInsertId());
        $comentarios->setId_post($id_post);
        $comentarios->setId_user($id_user);
        $comentarios->setCreated_at($created_at);
        $comentarios->setBody($body);

        if($sql->rowCount() >= 1){
            echo json_encode("Salvo com sucesso");
        }else {
            echo json_encode("Falha no envio de comentário");
        }

        
    }

    public function findAllforPost($idPost){
        $array = [];

        $sql = $this->pdo->prepare("SELECT * FROM comments WHERE id_post = :idPost");
        $sql->bindValue(':idPost', $idPost);
        $sql->execute();

        if($sql->rowCount() > 0){
            $data = $sql->fetchAll(PDO::FETCH_ASSOC);
            
            foreach($data as $item){
                $comentarios = new Comentarios();
                $comentarios->setId($item['id']);
                $comentarios->setId_post($item['id_post']);
                $comentarios->setId_user($item['id_user']);
                $comentarios->setCreated_at($item['created_at']);
                $comentarios->setBody($item['body']);

                $array[] = $comentarios;
            }
        }
        return $array;
    }
    
   
}