<?php
session_start();

// If the user is not logged in, redirect them to the home page
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit();
}

require_once __DIR__ . '/config.php';
require_once __DIR__ . '/src/db.php';

try {
    $pdo = get_pdo_connection();

    // Fetch all passes owned by the current user
    $stmt = $pdo->prepare(
        "SELECT p.name, up.pass_code, up.tickets_remaining, p.ticket_count, up.expiry_date
         FROM user_passes up
         JOIN passes p ON up.pass_id = p.id
         WHERE up.user_id = ?
         ORDER BY up.purchase_date DESC"
    );
    $stmt->execute([$_SESSION['user_id']]);
    $user_passes = $stmt->fetchAll();

} catch (PDOException $e) {
    // For a real app, you'd want to log this error and show a friendly message
    die("Could not retrieve user passes: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Anzu Dashboard</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="container">
        <header class="main-header">
            <div class="logo">Anzu</div>
            <nav>
                <a href="logout.php" class="btn-login">Logout</a>
            </nav>
        </header>
        <main>
            <section class="hero">
                <h1>Welcome, <?= htmlspecialchars($_SESSION['user_name']) ?>!</h1>
                <p>Here is an overview of your active cinema passes.</p>
            </section>

            <section class="dashboard-passes">
                <?php if (empty($user_passes)): ?>
                    <div class="no-passes-card">
                        <h2>You don't have any passes yet.</h2>
                        <a href="index.php" class="btn-purchase">Purchase a Pass</a>
                    </div>
                <?php else: ?>
                    <div class="passes-grid">
                        <?php foreach ($user_passes as $pass): ?>
                            <div class="pass-card user-pass-card">
                                <h2><?= htmlspecialchars($pass['name']) ?></h2>
                                <p class="pass-code-label">Your Pass Code:</p>
                                <p class="pass-code-display"><?= htmlspecialchars($pass['pass_code']) ?></p>
                                <div class="ticket-info">
                                    <p class="tickets-remaining">
                                        <strong><?= $pass['tickets_remaining'] ?></strong> / <?= $pass['ticket_count'] ?>
                                    </p>
                                    <p class="tickets-label">tickets remaining</p>
                                </div>
                                <p class="expiry-info">
                                    Expires on: <?= (new DateTime($pass['expiry_date']))->format('F j, Y') ?>
                                </p>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </section>
        </main>
    </div>
</body>
</html>