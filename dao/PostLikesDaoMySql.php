<?php
require_once 'models/PostLikes.php';

class PostLikesDaoMySql implements PostLikesDAO {
    private $pdo;

    public function __construct(PDO $driver) {
        $this->pdo = $driver;
    }
    public function add($id_post, $id_user){
        $sql = $this->pdo->prepare("INSERT INTO postlikes (id_post, id_user) VALUES (:id_post, :id_user)");
        $sql->bindValue(':id_post', $id_post);
        $sql->bindValue(':id_user', $id_user);
        $sql->execute();

        $postsLikes = new PostLikes();
        $postsLikes->setId($this->pdo->lastInsertId());
        $postsLikes->setId_post($id_post);
        $postsLikes->setId_user($id_user);
        return $postsLikes;

    }
    public function findAllByIdPost($id_post){
        $array = [];

        $sql = $this->pdo->query("SELECT COUNT(*) FROM postlikes WHERE id_post = :id_post");
        $sql->bindValue(':id_post',$id_post);
        $sql->execute();
        
        if($sql->rowCount() > 0){
            $data = $sql->fetchAll();

            foreach($data as $item){
                $postsLikes = new PostLikes();
                $postsLikes->setId($item['id']);
                $postsLikes->setId_post($item['id_post']);
                $postsLikes->setId_user($item['id_user']);
                $postsLikes->setCreated_at($item['created_at']);

                $array[] = $postsLikes;
            }
        }
        return $array;
    }

    public function getNumberOfLikes($idPost){

        $sql = $this->pdo->prepare("SELECT COUNT(*) AS TOTAL FROM postlikes WHERE id_post = :idPost;");
        $sql->bindValue(':idPost',$idPost);
        $sql->execute();
        $data = $sql->fetchColumn();
        return $data;

    }

    public function deleteLike($id){
        $sql = $this->pdo->prepare("DELETE FROM postlikes WHERE id = :id");
        $sql->bindValue(':id',$id);
        $sql->execute();
    }

    public function findById($idPost, $idUser){
        $sql = $this->pdo->prepare("SELECT * FROM postlikes WHERE id_post = :idPost AND id_user = :idUser");
        $sql->bindValue(':idPost', $idPost);
        $sql->bindValue(':idUser', $idUser);
        $sql->execute();

        if($sql->rowCount() > 0){
            $data = $sql->fetch(PDO::FETCH_ASSOC);

            $postsLikes = new PostLikes();
            $postsLikes->setId($data['id']);
            $postsLikes->getId_post($data['id_post']);
            $postsLikes->getId_user($data['id_user']);

            return $postsLikes;
        }else{
            return false;
        }
    }
}