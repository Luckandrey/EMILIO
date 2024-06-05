<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../src/Controllers/DatabaseController.php';

$databaseController = new DatabaseController($pdo);
$tables = $databaseController->getAllTables();

$selectedTable = isset($_POST['table']) ? $_POST['table'] : null;
$data = $selectedTable ? $databaseController->getTableData($selectedTable) : [];

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Tables</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include 'menu.php'; ?>
    <div class="container">
        <h1>View Tables</h1>
        <form method="post" action="read.php">
            <label for="table">Select Table:</label>
            <select name="table" id="table" onchange="this.form.submit()">
                <option value="">--Select a Table--</option>
                <?php foreach ($tables as $table): ?>
                    <option value="<?= $table ?>" <?= $selectedTable == $table ? 'selected' : '' ?>>
                        <?= $table ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </form>

        <?php if ($selectedTable): ?>
            <h2>Table: <?= $selectedTable ?></h2>
            <table>
                <thead>
                    <tr>
                        <?php if (!empty($data)): ?>
                            <?php foreach (array_keys($data[0]) as $column): ?>
                                <th><?= $column ?></th>
                            <?php endforeach; ?>
                            <th>Actions</th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($data as $row): ?>
                        <tr>
                            <?php foreach ($row as $cell): ?>
                                <td><?= htmlspecialchars($cell, ENT_QUOTES, 'UTF-8') ?></td>
                            <?php endforeach; ?>
                            <td>
                                <a href="delete.php?table=<?= $selectedTable ?>&id=<?= $row['id'] ?>" onclick="return confirm('Are you sure you want to delete this record?')">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</body>
</html>
