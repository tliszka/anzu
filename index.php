<?php
// public/index.php

// Include configuration and database connection
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/db.php';

try {
    $pdo = get_pdo_connection();
    
    // Fetch all available passes from the database
    $stmt = $pdo->query("SELECT name, description, price FROM passes ORDER BY price ASC");
    $passes = $stmt->fetchAll();

} catch (\PDOException $e) {
    // If the database connection fails, show an error.
    // In production, you'd show a more user-friendly page.
    die("Error: Could not connect to the database. " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Anzu Cinema Passes</title>
    <link rel="stylesheet" href="style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
</head>
<body>

    <div class="container">
        <header class="main-header">
            <div class="logo">Anzu</div>
            <nav>
                <a href="#login" class="btn-login">Login</a>
            </nav>
        </header>

        <main>
            <section class="hero">
                <h1>Anzu Cinema Passes - Welcome T1!</h1>
                <p>Purchase a pass and enjoy discounted tickets for the next six months.</p>
            </section>

            <section class="passes-grid">
                <?php foreach ($passes as $pass): ?>
                    <div class="pass-card">
                        <h2><?= htmlspecialchars($pass['name']) ?></h2>
                        <p class="description"><?= htmlspecialchars($pass['description']) ?></p>
                        <div class="price-container">
                            <span class="price">€<?= number_format($pass['price'], 2) ?></span>
                            <span class="validity">/ 6 months</span>
                        </div>
                        <a href="#purchase" class="btn-purchase">Purchase Pass</a>
                    </div>
                <?php endforeach; ?>
            </section>
        </main>
    </div>

</body>
</html>