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

// Updated SQL to query cricket_players table
$sql = "SELECT player_name, role, batting_average, debut_date FROM cricket_players ORDER BY player_id";
try {
    $stmt = $pdo->query($sql);
    $players = $stmt->fetchAll();
} catch (Exception $e) {
    $players = [];
    $errorMessage = "Error querying cricket_players table: " . $e->getMessage();
}

// Formatting functions
function formatAverage($avg) {
    return number_format((float)$avg, 2);
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
  <title>Cricket Players List</title>
  <style>
    body { font-family: Arial, sans-serif; margin: 40px; }
    table { border-collapse: collapse; width: 100%; max-width: 800px; }
    th, td { border: 1px solid #ccc; padding: 8px 12px; }
    th { background: #f5f5f5; }
  </style>
</head>
<body>
  <h1>Cricket Players List (Task 1)</h1>
  <?php if (!empty($errorMessage)): ?>
    <p style="color:red;"><?= htmlspecialchars($errorMessage) ?></p>
  <?php endif; ?>

  <table>
    <thead>
      <tr>
        <th>Player Name</th>
        <th>Role</th>
        <th>Batting Average</th>
        <th>Debut Date</th>
      </tr>
    </thead>
    <tbody>
      <?php if (empty($players)): ?>
        <tr><td colspan="4">No players found.</td></tr>
      <?php else: ?>
        <?php foreach ($players as $p): ?>
          <tr>
            <td><?= htmlspecialchars($p['player_name']) ?></td>
            <td><?= htmlspecialchars($p['role']) ?></td>
            <td><?= formatAverage($p['batting_average']) ?></td>
            <td><?= formatDate($p['debut_date']) ?></td>
          </tr>
        <?php endforeach; ?>
      <?php endif; ?>
    </tbody>
  </table>
</body>
</html>
