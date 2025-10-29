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

// Update query to use 'banks' table
$sql = "SELECT Bank_name, Branch, Interest_rate, Date_of_establishment FROM banks ORDER BY Bank_id";
try {
    $stmt = $pdo->query($sql);
    $banks = $stmt->fetchAll();
} catch (Exception $e) {
    $banks = [];
    $errorMessage = "Error querying banks table: " . $e->getMessage();
}

function formatInterest($rate) {
    return number_format((float)$rate, 2) . '%';
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
  <title>Banks List</title>
  <style>
    body { font-family: Arial, sans-serif; margin: 40px; }
    table { border-collapse: collapse; width: 100%; max-width: 800px; }
    th, td { border: 1px solid #ccc; padding: 8px 12px; }
    th { background: #f5f5f5; }
  </style>
</head>
<body>
  <h1>Banks List (Task 1)</h1>
  <?php if (!empty($errorMessage)): ?>
    <p style="color:red;"><?= htmlspecialchars($errorMessage) ?></p>
  <?php endif; ?>

  <table>
    <thead>
      <tr>
        <th>Bank Name</th>
        <th>Branch</th>
        <th>Interest Rate</th>
        <th>Date of Establishment</th>
      </tr>
    </thead>
    <tbody>
      <?php if (empty($banks)): ?>
        <tr><td colspan="4">No banks found.</td></tr>
      <?php else: ?>
        <?php foreach ($banks as $b): ?>
          <tr>
            <td><?= htmlspecialchars($b['Bank_name']) ?></td>
            <td><?= htmlspecialchars($b['Branch']) ?></td>
            <td><?= formatInterest($b['Interest_rate']) ?></td>
            <td><?= formatDate($b['Date_of_establishment']) ?></td>
          </tr>
        <?php endforeach; ?>
      <?php endif; ?>
    </tbody>
  </table>
</body>
</html>
