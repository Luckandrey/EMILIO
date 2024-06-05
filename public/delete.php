<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../src/Controllers/DatabaseController.php';

$databaseController = new DatabaseController($pdo);

// Receber o ID e a Tabela do Registro a Ser Excluído
$id = isset($_GET['id']) ? intval($_GET['id']) : null;
$table = isset($_GET['table']) ? $_GET['table'] : null;

if ($id && $table) {
    // Validar o ID e a Tabela
    if ($databaseController->deleteRecord($table, $id)) {
        // Redirecionar ou Fornecer Feedback ao Usuário
        header("Location: read.php?message=Record deleted successfully.");
        exit();
    } else {
        $error = "Failed to delete the record.";
    }
} else {
    $error = "Invalid ID or Table.";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Record</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include 'menu.php'; ?>
    <div class="container">
        <h1>Delete Record</h1>
        <?php if (isset($error)): ?>
            <p><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></p>
        <?php else: ?>
            <p>Record deleted successfully.</p>
        <?php endif; ?>
        <a href="read.php">Back to list</a>
    </div>
</body>
</html>
