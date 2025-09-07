<?php
require_once __DIR__ . '/src/auth.php'; // Use our new auth helper
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/src/db.php';

$error_message = '';
if (isset($_GET['error'])) {
    $error_code = $_GET['error'];
    switch ($error_code) {
        case 'invalid_credentials':
            $error_message = 'Invalid email or password.';
            break;
        case 'email_exists':
            $error_message = 'An account with this email already exists.';
            break;
        case 'invalid_input':
            $error_message = 'Please fill in all fields correctly.';
            break;
        default:
            $error_message = 'An unexpected error occurred. Please try again.';
            break;
    }
}

try {
    $pdo = get_pdo_connection();
    $stmt = $pdo->query("SELECT id, name, description, price FROM passes ORDER BY price ASC");
    $passes = $stmt->fetchAll();
} catch (\PDOException $e) {
    die("Error: Could not connect to the database. " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Anzu Cinema Passes</title>
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
                <?php if (is_user_logged_in()): ?>
                    <a href="dashboard.php" class="btn-login">Dashboard</a>
                <?php else: ?>
                    <a href="#login" class="btn-login">Login</a>
                <?php endif; ?>
            </nav>
        </header>

        <main>
            <section class="hero">
                <h1>Anzu Cinema Passes</h1>
                <p>Purchase a pass and enjoy discounted tickets for the next six months.</p>
            </section>

            <section class="passes-grid">
                <?php foreach ($passes as $pass): ?>
                    <div class="pass-card" data-pass-id="<?= $pass['id'] ?>">
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

    <div id="auth-modal" class="modal-overlay" style="display: none;">
        <div class="modal-content">
            <span class="close-modal">&times;</span>

            <?php if ($error_message): ?>
                <div class="error-banner"><?= htmlspecialchars($error_message) ?></div>
            <?php endif; ?>

            <div class="modal-tabs">
                <button class="tab-link active" data-tab="login">Login</button>
                <button class="tab-link" data-tab="signup">Sign Up</button>
            </div>

            <div id="login" class="tab-content active">
                <form action="login.php" method="POST">
                    <div class="input-group">
                        <label for="login-email">Email</label>
                        <input type="email" id="login-email" name="email" required>
                    </div>
                    <div class="input-group">
                        <label for="login-password">Password</label>
                        <input type="password" id="login-password" name="password" required>
                    </div>
                    <button type="submit" class="btn-primary">Login</button>
                    <a href="#" class="forgot-password-link" data-tab="forgot">Forgot Password?</a>
                </form>
            </div>

            <div id="signup" class="tab-content">
                <h3 id="signup-title">Create Your Account</h3>
                <form action="signup.php" method="POST">
                    <input type="hidden" id="signup-pass-id" name="pass_id" value="">
                    <div class="input-group">
                        <label for="signup-name">Full Name</label>
                        <input type="text" id="signup-name" name="name" required>
                    </div>
                    <div class="input-group">
                        <label for="signup-email">Email</label>
                        <input type="email" id="signup-email" name="email" required>
                    </div>
                    <div class="input-group">
                        <label for="signup-password">Password</label>
                        <input type="password" id="signup-password" name="password" required>
                    </div>
                    <button type="submit" class="btn-primary">Sign Up & Purchase</button>
                </form>
            </div>

            <div id="forgot" class="tab-content">
                <h3>Reset Password</h3>
                <p>Enter your email and we'll send you a link to reset your password.</p>
                <form action="forgot.php" method="POST">
                    <div class="input-group">
                        <label for="forgot-email">Email</label>
                        <input type="email" id="forgot-email" name="email" required>
                    </div>
                    <button type="submit" class="btn-primary">Send Reset Link</button>
                </form>
            </div>
        </div>
    </div>

    <script src="js/app.js"></script>
    <?php if ($error_message): ?>
    <script>
        // If there's an error, automatically open the modal
        document.addEventListener('DOMContentLoaded', () => {
            document.getElementById('auth-modal').style.display = 'flex';
        });
    </script>
    <?php endif; ?>
</body>
</html>