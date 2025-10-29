<?php
$dbHost = 'localhost';
$dbName = 'db2417131';
$dbUser = '2417131';
$dbPass = 'University2025@#$&';

$dsn = "mysql:host=$dbHost;dbname=$dbName;charset=utf8mb4";

$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];

try {
    $pdo = new PDO($dsn, $dbUser, $dbPass, $options);
} catch (Exception $e) {
    die("<h1>Database connection failed</h1><p>Check DB credentials and that your database exists.</p><pre>" . htmlspecialchars($e->getMessage()) . "</pre>");
}

$sql = "SELECT country_name, continent, population, date_of_independence FROM countries ORDER BY country_id";
try {
    $stmt = $pdo->query($sql);
    $countries = $stmt->fetchAll();
} catch (Exception $e) {
    $countries = [];
    $errorMessage = "Error querying countries table: " . $e->getMessage();
}

function formatPopulation($population) {
    return number_format((float)$population, 1) . ' million';
}

function formatDate($dateStr) {
    if (!$dateStr) return '';
    $d = DateTime::createFromFormat('Y-m-d', $dateStr);
    return $d ? $d->format('d/m/Y') : htmlspecialchars($dateStr);
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Countries List</title>
  <style>
    body { font-family: Arial, sans-serif; margin: 40px; background-color: #f8f9fa; }
    table { border-collapse: collapse; width: 100%; max-width: 800px; margin-top: 20px; background: white; }
    th, td { border: 1px solid #ccc; padding: 8px 12px; text-align: left; }
    th { background: #f0f0f0; }
    h1 { color: #333; }
  </style>
</head>
<body>
  <h1>Countries List (Task 1)</h1>
  <?php if (!empty($errorMessage)): ?>
    <p style="color:red;"><?= htmlspecialchars($errorMessage) ?></p>
  <?php endif; ?>

  <table>
    <thead>
      <tr>
        <th>Country Name</th>
        <th>Continent</th>
        <th>Population</th>
        <th>Date of Independence</th>
      </tr>
    </thead>
    <tbody>
      <?php if (empty($countries)): ?>
        <tr><td colspan="4">No countries found.</td></tr>
      <?php else: ?>
        <?php foreach ($countries as $c): ?>
          <tr>
            <td><?= htmlspecialchars($c['country_name']) ?></td>
            <td><?= htmlspecialchars($c['continent']) ?></td>
            <td><?= formatPopulation($c['population']) ?></td>
            <td><?= formatDate($c['date_of_independence']) ?></td>
          </tr>
        <?php endforeach; ?>
      <?php endif; ?>
    </tbody>
  </table>
</body>
</html>
