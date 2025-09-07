<?php
session_start();

// If the user is not logged in, redirect them to the home page
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit();
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
            <h1>Welcome, <?= htmlspecialchars($_SESSION['user_name']) ?>!</h1>
            <p>This is your dashboard. We will build the pass overview here in the next step.</p>
        </main>
    </div>
</body>
</html>