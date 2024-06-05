<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../src/Controllers/DatabaseController.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);

$databaseController = new DatabaseController($pdo);
$tables = $databaseController->getAllTables();

$selectedTable = isset($_POST['table']) ? $_POST['table'] : null;
$columns = $selectedTable ? $databaseController->getTableColumns($selectedTable) : [];

// Descrições dos campos para cada tabela
$fieldDescriptions = [
    'continent' => [
        'id' => 'Unique identifier for the continent',
        'continent_name' => 'Name of the continent'
    ],
    'country' => [
        'id' => 'Unique identifier for the country',
        'continent_id' => 'Identifier for the continent',
        'level0gid' => 'Country code (e.g., BR for Brazil)',
        'country_name' => 'Name of the country'
    ],
    'state_table' => [
        'id' => 'Unique identifier for the state',
        'country_id' => 'Identifier for the country',
        'state_code' => 'State code (e.g., SP for São Paulo)',
        'state_name' => 'Name of the state'
    ],
    'city' => [
        'id' => 'Unique identifier for the city',
        'state_id' => 'Identifier for the state',
        'city_code' => 'City code',
        'city_name' => 'Name of the city'
    ],
    'localization' => [
        'id' => 'Unique identifier for the localization',
        'latitude' => 'Latitude of the location',
        'longitude' => 'Longitude of the location'
    ],
    'rights' => [
        'id' => 'Unique identifier for the rights record',
        'description' => 'Description of the rights'
    ],
    'research' => [
        'id' => 'Unique identifier for the research',
        'title' => 'Title of the research',
        'description' => 'Description of the research'
    ],
    'research_issue' => [
        'id' => 'Unique identifier for the research issue',
        'issue_description' => 'Description of the issue'
    ],
    'issue' => [
        'id' => 'Unique identifier for the issue',
        'issue_title' => 'Title of the issue',
        'issue_details' => 'Details of the issue'
    ],
    'researched_by' => [
        'research_id' => 'Identifier for the research',
        'researcher_id' => 'Identifier for the researcher'
    ],
    'researcher' => [
        'id' => 'Unique identifier for the researcher',
        'name' => 'Name of the researcher',
        'institution' => 'Institution of the researcher'
    ],
    'kingdom' => [
        'id' => 'Unique identifier for the kingdom',
        'kingdom_name' => 'Name of the kingdom'
    ],
    'taxon_hierarchy' => [
        'id' => 'Unique identifier for the taxon hierarchy',
        'hierarchy_level' => 'Hierarchy level'
    ],
    'phylum' => [
        'id' => 'Unique identifier for the phylum',
        'phylum_name' => 'Name of the phylum'
    ],
    'class_table' => [
        'id' => 'Unique identifier for the class',
        'class_name' => 'Name of the class'
    ],
    'order_table' => [
        'id' => 'Unique identifier for the order',
        'order_name' => 'Name of the order'
    ],
    'family_table' => [
        'id' => 'Unique identifier for the family',
        'family_name' => 'Name of the family'
    ],
    'genus' => [
        'id' => 'Unique identifier for the genus',
        'genus_name' => 'Name of the genus'
    ],
    'species' => [
        'id' => 'Unique identifier for the species',
        'species_name' => 'Name of the species'
    ],
    'taxon' => [
        'id' => 'Unique identifier for the taxon',
        'taxon_name' => 'Name of the taxon'
    ],
    'taxon_sample' => [
        'id' => 'Unique identifier for the taxon sample',
        'sample_details' => 'Details of the sample'
    ],
    'log' => [
        'id' => 'Unique identifier for the log entry',
        'event_type' => 'Type of event',
        'description' => 'Description of the event'
    ],
    'taxon_density' => [
        'id' => 'Unique identifier for the taxon density',
        'density_value' => 'Value of the density'
    ],
    'researchers_timeline' => [
        'id' => 'Unique identifier for the timeline entry',
        'researcher_id' => 'Identifier for the researcher',
        'event_date' => 'Date of the event'
    ],
    'issues_quantity' => [
        'id' => 'Unique identifier for the issues quantity record',
        'quantity' => 'Quantity of issues'
    ],
    'taxon_quantity' => [
        'id' => 'Unique identifier for the taxon quantity record',
        'quantity' => 'Quantity of taxons'
    ],
    'researchers_team_discover' => [
        'id' => 'Unique identifier for the discovery record',
        'team_id' => 'Identifier for the team',
        'discovery_date' => 'Date of the discovery'
    ]
    // Adicione mais descrições conforme necessário
];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['create'])) {
    $data = [];
    foreach ($columns as $column) {
        $data[$column] = trim($_POST[$column]);
    }

    // Validação no servidor
    $valid = true;
    foreach ($data as $key => $value) {
        if (empty($value)) {
            $valid = false;
            $error = "All fields are required.";
            break;
        }
    }

    if ($valid) {
        $databaseController->createRecord($selectedTable, $data);
        header("Location: read.php");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Record</title>
    <link rel="stylesheet" href="style.css">
    <script>
        function validateForm() {
            var inputs = document.querySelectorAll('input[type="text"]');
            for (var i = 0; i < inputs.length; i++) {
                if (inputs[i].value === "") {
                    alert("All fields must be filled out");
                    return false;
                }
            }
            return true;
        }
    </script>
</head>
<body>
    <?php include 'menu.php'; ?>
    <div class="container">
        <h1>Create Record</h1>
        <form method="post" action="create.php">
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

        <?php if ($selectedTable && !empty($columns)): ?>
            <?php if (isset($error)): ?>
                <p><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></p>
            <?php endif; ?>
            <form method="post" action="create.php" onsubmit="return validateForm()">
                <input type="hidden" name="table" value="<?= $selectedTable ?>">
                <?php foreach ($columns as $column): ?>
                    <label for="<?= $column ?>"><?= $column ?>: <small><?= $fieldDescriptions[$selectedTable][$column] ?? '' ?></small></label>
                    <input type="text" name="<?= $column ?>" id="<?= $column ?>" required>
                <?php endforeach; ?>
                <button type="submit" name="create">Create</button>
            </form>
        <?php endif; ?>
    </div>
</body>
</html>