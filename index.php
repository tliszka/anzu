<?php
// TOP OF THE FILE
require_once __DIR__ . '/src/auth.php';
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/src/db.php';

// ADD THIS LINE TO GET THE TIMESTAMP
$lastModifiedTimestamp = filemtime(__FILE__);
$lastModifiedDatetime = date("Y-m-d H:i:s", $lastModifiedTimestamp);

$error_message = '';
// ... (rest of the PHP code is the same) ...
?>
<!DOCTYPE html>
<html lang="en">
<body>

    <script src="js/app.js"></script>
    <?php if ($error_message): ?>
    <script>
        // If there's an error, automatically open the modal
        document.addEventListener('DOMContentLoaded', () => {
            document.getElementById('auth-modal').style.display = 'flex';
        });
    </script>
    <?php endif; ?>

    <div class="version-timestamp">
        Last updated: <?= $lastModifiedDatetime ?>
    </div>

</body>
</html>