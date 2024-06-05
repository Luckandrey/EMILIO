<?php
require_once __DIR__ . '../../../config/database.php';
require_once __DIR__ . '../../Models/Record.php';

// Classe CrudController
class CrudController {
    private $pdo;
    private $recordModel;

    public function __construct($pdo) {
        $this->pdo = $pdo;
        $this->recordModel = new Record($pdo);
    }

    public function create($data) {
        $this->recordModel->create($data);
    }

    public function readAll() {
        return $this->recordModel->readAll();
    }

    public function read($id) {
        return $this->recordModel->read($id);
    }

    public function update($id, $data) {
        $this->recordModel->update($id, $data);
    }

    public function delete($id) {
        $this->recordModel->delete($id);
    }
}
?>
