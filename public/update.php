<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../src/Controllers/DatabaseController.php';

$databaseController = new DatabaseController($pdo);
$tables = $databaseController->getAllTables();

$selectedTable = isset($_POST['table']) ? $_POST['table'] : null;
$id = isset($_GET['id']) ? $_GET['id'] : null;
$columns = $selectedTable ? $databaseController->getTableColumns($selectedTable) : [];
$record = $id ? $databaseController->getRecordById($selectedTable, $id) : [];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
    $data = [];
    foreach ($columns as $column) {
        $data[$column] = $_POST[$column];
    }
    $databaseController->updateRecord($selectedTable, $id, $data);
    header("Location: read.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Record</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include 'menu.php'; ?>
    <div class="container">
        <h1>Update Record</h1>
        <?php if ($selectedTable && !empty($columns) && !empty($record)): ?>
            <form method="post" action="update.php?id=<?= $id ?>">
                <input type="hidden" name="table" value="<?= $selectedTable ?>">
                <?php foreach ($columns as $column): ?>
                    <label for="<?= $column ?>"><?= $column ?>:</label>
                    <input type="text" name="<?= $column ?>" id="<?= $column ?>" value="<?= htmlspecialchars($record[$column], ENT_QUOTES, 'UTF-8') ?>" required>
                <?php endforeach; ?>
                <button type="submit" name="update">Update</button>
            </form>
        <?php endif; ?>
    </div>
</body>
</html>