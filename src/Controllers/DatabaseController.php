<?php
require_once __DIR__ . '../../Models/Database.php';

class DatabaseController {
    private $pdo;
    private $databaseModel;

    public function __construct($pdo) {
        $this->pdo = $pdo;
        $this->databaseModel = new Database($pdo);
    }

    public function getAllTables() {
        return $this->databaseModel->getAllTables();
    }

    public function getTableData($tableName) {
        return $this->databaseModel->getTableData($tableName);
    }

    public function getTableColumns($tableName) {
        return $this->databaseModel->getTableColumns($tableName);
    }

    public function createRecord($tableName, $data) {
        return $this->databaseModel->createRecord($tableName, $data);
    }

    public function getRecordById($tableName, $id) {
        return $this->databaseModel->getRecordById($tableName, $id);
    }

    public function updateRecord($tableName, $id, $data) {
        return $this->databaseModel->updateRecord($tableName, $id, $data);
    }

    public function deleteRecord($tableName, $id) {
        return $this->databaseModel->deleteRecord($tableName, $id);
    }
}
?>
