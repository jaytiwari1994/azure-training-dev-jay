<?php
// Azure SQL configuration
$server   = "sql-server-app-training-dev.privatelink.database.windows.net";
$database = "SQL-DB-APP-TRAINING-DEV";
$username = "JAY-TRAINING-DEV-SQL-SERVER";
$password = "Jjj060494@123";

$tableData = [];
$error = "";

if (isset($_POST['fetch'])) {
    try {
        // PDO connection
        $conn = new PDO(
            "sqlsrv:server=$server;Database=$database",
            $username,
            $password
        );
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Query
        $sql = "SELECT * FROM USERS";
        $stmt = $conn->prepare($sql);
        $stmt->execute();

        $tableData = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        $error = $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Azure SQL Data Viewer</title>
    <style>
        table {
            border-collapse: collapse;
            width: 80%;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #333;
            padding: 8px;
        }
        th {
            background: #f4f4f4;
        }
    </style>
</head>
<body>

	<h2>Fetch Azure SQL Table Data</h2>

	<form method="post">
		<button type="submit" name="fetch">Fetch Data</button>
	</form>

	<?php if ($error): ?>
		<p style="color:red;">Error: <?= htmlspecialchars($error) ?></p>
	<?php endif; ?>

	<?php if (!empty($tableData)): ?>
		<table>
			<tr>
				<?php foreach (array_keys($tableData[0]) as $column): ?>
					<th><?= htmlspecialchars($column) ?></th>
				<?php endforeach; ?>
			</tr>

			<?php foreach ($tableData as $row): ?>
				<tr>
					<?php foreach ($row as $value): ?>
						<td><?= htmlspecialchars($value) ?></td>
					<?php endforeach; ?>
				</tr>
			<?php endforeach; ?>
		</table>
	<?php endif; ?>

</body>
</html>
