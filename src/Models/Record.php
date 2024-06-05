<?php
class Record {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // Método para criar um novo registro na tabela 'research'
    public function create($data) {
        $stmt = $this->pdo->prepare("INSERT INTO research (title, description) VALUES (:title, :description)");
        $stmt->execute(['title' => $data['title'], 'description' => $data['description']]);
    }

    // Método para ler todos os registros da tabela 'research'
    public function readAll() {
        $stmt = $this->pdo->query("SELECT * FROM research");
        return $stmt->fetchAll();
    }

    // Método para ler um registro específico da tabela 'research' pelo ID
    public function read($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM research WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    // Método para atualizar um registro específico na tabela 'research'
    public function update($id, $data) {
        $stmt = $this->pdo->prepare("UPDATE research SET title = :title, description = :description WHERE id = :id");
        $stmt->execute(['title' => $data['title'], 'description' => $data['description'], 'id' => $id]);
    }

    // Método para deletar um registro específico da tabela 'research'
    public function delete($id) {
        $stmt = $this->pdo->prepare("DELETE FROM research WHERE id = :id");
        $stmt->execute(['id' => $id]);
    }
}
?>
