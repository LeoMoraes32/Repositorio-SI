<?php
require_once 'models/Tags.php';

class TagsDaoMySql implements TagsDAO {
    private $pdo;

    public function __construct(PDO $driver) {
        $this->pdo = $driver;
    }
    public function add($tag, $id_post_fk){
        $sql = $this->pdo->prepare("INSERT INTO tags (tag, id_post_fk) VALUES (:tag, :id_post_fk)");
        $sql->bindValue(':tag', $tag);
        $sql->bindValue(':id_post_fk', $id_post_fk);
        $sql->execute();

        $tags = new Tags();
        $tags->setTag($tag);
        $tags->setId_post_fk($id_post_fk);

        return $tags;
    }

    public function findAll(){
        $array = [];

        $sql = $this->pdo->query("SELECT * FROM tags ORDER BY id_post_fk DESC");
        if($sql->rowCount() > 0){
            $data = $sql->fetchAll();

            foreach($data as $item) {
                $tags = new Tags();
                $tags->setTag($item['tag']);
                $tags->setId_post_fk($item['id_post_fk']);

                $array[] = $tags;
            }
        }
        return $array;
    }
    
    public function findById($id_post_fk){
        $array = [];
        $sql = $this->pdo->prepare("SELECT * FROM tags WHERE id_post_fk = :id_post_fk");
        $sql->bindValue(':id_post_fk', $id_post_fk);
        $sql->execute();

        if($sql->rowCount() > 0){
            $data = $sql->fetchAll();
            
            foreach($data as $item){
                $tags = new Tags();
                $tags->setTag($item['tag']);
                $tags->setId_post_fk($item['id_post_fk']);
               

                $array[] = $tags;
            }
        }
        return $array;
    }
    
    public function findLike($title){
        $array = [];

        
        $sql = $this->pdo->prepare("SELECT * FROM tags WHERE tag LIKE :title ORDER BY id_post_fk DESC");
        $sql->bindValue(':title', "%$title%");
        $sql->execute();
        
        if($sql->rowCount() > 0) {
            $data = $sql->fetchAll(PDO::FETCH_ASSOC);

            foreach($data as $item) {
                $tags = new Tags();
                $tags->setTag($item['tag']);
                $tags->setId_post_fk($item['id_post_fk']);
             
                $array[] = $tags;
            }
        }
        return $array;
    }
    public function update($tag, $id_post_fk){
        $sql = $this->pdo->prepare("UPDATE tags SET tag=:tag WHERE id_post_fk =:id_post_fk");
        $sql->bindValue(':tag', $tag);
        $sql->bindValue(':id_post_fk', $id_post_fk);
        $sql->execute();

        return true;
    }

    public function delete($id_post_fk){
        $sql = $this->pdo->prepare("DELETE FROM tags WHERE id_post_fk = :id_post_fk");
        $sql->bindValue(':id_post_fk', $id_post_fk);
        $sql->execute();
    }
    
}