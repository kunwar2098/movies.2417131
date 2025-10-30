<?php
// Database connection details
$dbHost = 'localhost';
$dbName = 'db2417131';
$dbUser = '2417131';
$dbPass = 'University2025@#$&';

$dsn = "mysql:host=$dbHost;dbname=$dbName;charset=utf8mb4";

$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];

// Try connecting to database
try {
    $pdo = new PDO($dsn, $dbUser, $dbPass, $options);
} catch (Exception $e) {
    die("<h1>Database connection failed</h1><p>Check DB credentials and that your database exists.</p><pre>" . htmlspecialchars($e->getMessage()) . "</pre>");
}

// SQL query to retrieve university data
$sql = "SELECT uni_name, location, ranking, date_established FROM universities ORDER BY uni_id";
try {
    $stmt = $pdo->query($sql);
    $universities = $stmt->fetchAll();
} catch (Exception $e) {
    $universities = [];
    $errorMessage = "Error querying universities table: " . $e->getMessage();
}

// Helper functions
function formatRanking($ranking) {
    return number_format((float)$ranking, 1);
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
  <title>University List</title>
  <style>
    body { font-family: Arial, sans-serif; margin: 40px; }
    table { border-collapse: collapse; width: 100%; max-width: 800px; }
    th, td { border: 1px solid #ccc; padding: 8px 12px; text-align: left; }
    th { background: #f5f5f5; }
    h1 { color: #333; }
  </style>
</head>
<body>
  <h1>University List (Task 1)</h1>
  <?php if (!empty($errorMessage)): ?>
    <p style="color:red;"><?= htmlspecialchars($errorMessage) ?></p>
  <?php endif; ?>

  <table>
    <thead>
      <tr>
        <th>University Name</th>
        <th>Location</th>
        <th>Ranking</th>
        <th>Date Established</th>
      </tr>
    </thead>
    <tbody>
      <?php if (empty($universities)): ?>
        <tr><td colspan="4">No universities found.</td></tr>
      <?php else: ?>
        <?php foreach ($universities as $u): ?>
          <tr>
            <td><?= htmlspecialchars($u['uni_name']) ?></td>
            <td><?= htmlspecialchars($u['location']) ?></td>
            <td><?= formatRanking($u['ranking']) ?></td>
            <td><?= formatDate($u['date_established']) ?></td>
          </tr>
        <?php endforeach; ?>
      <?php endif; ?>
    </tbody>
  </table>
</body>
</html>
