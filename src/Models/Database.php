<?php
class Database {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function getAllTables() {
        $stmt = $this->pdo->query("SELECT table_name FROM information_schema.tables WHERE table_schema = 'public'");
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    public function getTableData($tableName) {
        $stmt = $this->pdo->query("SELECT * FROM $tableName");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTableColumns($tableName) {
        $stmt = $this->pdo->prepare("SELECT column_name FROM information_schema.columns WHERE table_name = :tableName");
        $stmt->execute(['tableName' => $tableName]);
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    public function createRecord($tableName, $data) {
        $columns = implode(", ", array_keys($data));
        $values = implode(", ", array_map(fn($value) => ":$value", array_keys($data)));
        $stmt = $this->pdo->prepare("INSERT INTO $tableName ($columns) VALUES ($values)");
        return $stmt->execute($data);
    }

    public function getRecordById($tableName, $id) {
        $stmt = $this->pdo->prepare("SELECT * FROM $tableName WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateRecord($tableName, $id, $data) {
        $setClause = implode(", ", array_map(fn($key) => "$key = :$key", array_keys($data)));
        $stmt = $this->pdo->prepare("UPDATE $tableName SET $setClause WHERE id = :id");
        $data['id'] = $id;
        return $stmt->execute($data);
    }

    public function deleteRecord($tableName, $id) {
        $stmt = $this->pdo->prepare("DELETE FROM $tableName WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }
    
}
?>
