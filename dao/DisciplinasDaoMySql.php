<?php
require_once 'models/Disciplina.php';

class DisciplinasDaoMySql implements DisciplinaDAO{
    private $pdo;

    public function __construct(PDO $driver) {
        $this->pdo = $driver;
    }

    
    
    public function findById($id){
        $sql = $this->pdo->prepare("SELECT * FROM disciplina WHERE id = :id");
        $sql->bindValue(':id', $id);
        $sql->execute();

        if($sql->rowCount() > 0){
            $data = $sql->fetch(PDO::FETCH_ASSOC);

            $disciplina = new Disciplina();
            $disciplina->setId($data['id']);
            $disciplina->setNome($data['nome']);
            $disciplina->setAno($data['ano']);
            $disciplina->setCarga($data['carga']);
            $disciplina->setCurso($data['curso']);
            $disciplina->setEmenta($data['ementa']);

            return $disciplina;
        }else{
            return false;
        }
    }
    public function findMoreUsed(){
        $sql = $this->pdo->query("SELECT * FROM disciplina ORDER BY qtd_posts DESC LIMIT 3");
        if($sql->rowCount() > 0) {
            $data = $sql->fetchAll();

            foreach($data as $item) {
                $disciplina = new Disciplina();
                $disciplina->setId($item['id']);
                $disciplina->setNome($item['nome']);
                $disciplina->setAno($item['ano']);
                $disciplina->setCarga($item['carga']);
                $disciplina->setCurso($item['curso']);
                $disciplina->setEmenta($item['ementa']);
                $disciplina->setQtd_posts($item['qtd_posts']);

                $array[] = $disciplina;
            }
        }
        return $array;
    }

    public function updateQtd_posts($id){
        $sql = $this->pdo->prepare("UPDATE disciplina SET qtd_posts = qtd_posts + 1 WHERE id = :id");
        $sql->bindValue(':id', $id);
        $sql->execute();

        return true;
    }
}