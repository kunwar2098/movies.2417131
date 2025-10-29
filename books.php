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

$sql = "SELECT book_name, genre, price, date_of_release FROM books ORDER BY book_id";
try {
    $stmt = $pdo->query($sql);
    $books = $stmt->fetchAll();
} catch (Exception $e) {
    $books = [];
    $errorMessage = "Error querying books table: " . $e->getMessage();
}

function formatPrice($price) {
    return '£' . number_format((float)$price, 2);
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
  <title>Books List</title>
  <style>
    body { font-family: Arial, sans-serif; margin: 40px; background-color: #fafafa; }
    table { border-collapse: collapse; width: 100%; max-width: 800px; margin-top: 20px; }
    th, td { border: 1px solid #ccc; padding: 8px 12px; text-align: left; }
    th { background: #f5f5f5; }
    h1 { color: #333; }
  </style>
</head>
<body>
  <h1>Books List (Task 1)</h1>

  <?php if (!empty($errorMessage)): ?>
    <p style="color:red;"><?= htmlspecialchars($errorMessage) ?></p>
  <?php endif; ?>

  <table>
    <thead>
      <tr>
        <th>Book Name</th>
        <th>Genre</th>
        <th>Price</th>
        <th>Date of Release</th>
      </tr>
    </thead>
    <tbody>
      <?php if (empty($books)): ?>
        <tr><td colspan="4">No books found.</td></tr>
      <?php else: ?>
        <?php foreach ($books as $b): ?>
          <tr>
            <td><?= htmlspecialchars($b['book_name']) ?></td>
            <td><?= htmlspecialchars($b['genre']) ?></td>
            <td><?= formatPrice($b['price']) ?></td>
            <td><?= formatDate($b['date_of_release']) ?></td>
          </tr>
        <?php endforeach; ?>
      <?php endif; ?>
    </tbody>
  </table>
</body>
</html>
