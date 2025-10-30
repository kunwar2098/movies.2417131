<?php
// Database credentials
$dbHost = 'localhost';
$dbName = 'db2417131';
$dbUser = '2417131';
$dbPass = 'University2025@#$&';

// Set up DSN and options
$dsn = "mysql:host=$dbHost;dbname=$dbName;charset=utf8mb4";
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];

try {
    $pdo = new PDO($dsn, $dbUser, $dbPass, $options);
} catch (Exception $e) {
    die("<h1>Database connection failed</h1>
         <p>Please check your credentials or database name.</p>
         <pre>" . htmlspecialchars($e->getMessage()) . "</pre>");
}

// Query the movies table (matching exam spec)
$sql = "SELECT movie_name, genre, price, date_of_release FROM movies ORDER BY movie_id";

try {
    $stmt = $pdo->query($sql);
    $movies = $stmt->fetchAll();
} catch (Exception $e) {
    $movies = [];
    $errorMessage = "Error retrieving movie data: " . $e->getMessage();
}

// Format helpers
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
  <title>Movies List - Task 1</title>
  <style>
    body { font-family: Arial, sans-serif; margin: 40px; }
    table { border-collapse: collapse; width: 100%; max-width: 800px; }
    th, td { border: 1px solid #ccc; padding: 8px 12px; text-align: left; }
    th { background-color: #f5f5f5; }
  </style>
</head>
<body>
  <h1>Movies List (5CS045 - Task 1)</h1>

  <?php if (!empty($errorMessage)): ?>
    <p style="color:red;"><?= htmlspecialchars($errorMessage) ?></p>
  <?php endif; ?>

  <table>
    <thead>
      <tr>
        <th>Movie Name</th>
        <th>Genre</th>
        <th>Price</th>
        <th>Date of Release</th>
      </tr>
    </thead>
    <tbody>
      <?php if (empty($movies)): ?>
        <tr><td colspan="4">No movies found.</td></tr>
      <?php else: ?>
        <?php foreach ($movies as $m): ?>
          <tr>
            <td><?= htmlspecialchars($m['movie_name']) ?></td>
            <td><?= htmlspecialchars($m['genre']) ?></td>
            <td><?= formatPrice($m['price']) ?></td>
            <td><?= formatDate($m['date_of_release']) ?></td>
          </tr>
        <?php endforeach; ?>
      <?php endif; ?>
    </tbody>
  </table>
</body>
</html>
