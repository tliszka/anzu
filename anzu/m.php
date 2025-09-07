<?php
// === DUMMY ADATOK (SQL HELYETT) ===
// Később ezeket adatbázis-lekérdezésekkel helyettesítjük.

// 1. A bejelentkezett felhasználó és a bérletének adatai
$loggedInUser = [
    'id' => 12,
    'name' => 'Kovács Anna',
    'email' => 'kovacs.anna@email.com',
    'pass' => [
        'type_name' => '25%-os Bérlet',
        'credits' => 14,
        'valid_until' => '2026-02-25' // A 6 hónapos érvényességet itt szimuláljuk
    ]
];

// 2. A megvásárolható bérlettípusok
$passTypes = [
    [
        'id' => 1,
        'name' => '20%-os Bérlet',
        'discount' => 20,
        'price' => 24720, // 8 jegy ára
        'credits' => 10,
        'description' => 'Fizess 8 jegyért, kapj 10-et!'
    ],
    [
        'id' => 2,
        'name' => '25%-os Bérlet',
        'discount' => 25,
        'price' => 46350, // 15 jegy ára
        'credits' => 20,
        'description' => 'Fizess 15 jegyért, kapj 20-at!'
    ],
    [
        'id' => 3,
        'name' => '30%-os Bérlet',
        'discount' => 30,
        'price' => 64890, // 21 jegy ára
        'credits' => 30,
        'description' => 'Fizess 21 jegyért, kapj 30-at!'
    ]
];
?>
<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MoziBérlet Kezelő</title>
    <link rel="stylesheet" href="m.css">
</head>
<body>

    <header>
        <h1><a href="#">MoziBérlet</a></h1>
        <nav>
            <span>Szia, <?= htmlspecialchars($loggedInUser['name']) ?>!</span>
            <a href="#logout" class="button-secondary">Kijelentkezés</a>
        </nav>
    </header>

    <main>
        <div id="view-customer">
            
            <section class="card current-pass">
                <h2>Aktuális bérleted</h2>
                <h3><?= htmlspecialchars($loggedInUser['pass']['type_name']) ?></h3>
                <div class="credits-display">
                    <p>Felhasználható kreditek:</p>
                    <span><?= $loggedInUser['pass']['credits'] ?></span>
                </div>
                <p class="validity">Érvényes eddig: <?= $loggedInUser['pass']['valid_until'] ?></p>
            </section>

            <section class="pass-options">
                <h2>Új bérlet vásárlása</h2>
                <div class="options-container">
                    <?php foreach ($passTypes as $pass): ?>
                        <div class="card pass-card">
                            <h3><?= htmlspecialchars($pass['name']) ?></h3>
                            <p class="description"><?= htmlspecialchars($pass['description']) ?></p>
                            <div class="price"><?= number_format($pass['price'], 0, ',', ' ') ?> Ft</div>
                            <button class="button-primary">Vásárlás</button>
                        </div>
                    <?php endforeach; ?>
                </div>
            </section>

        </div>

        <div id="view-cashier" style="display: none;">
            <h2>Bérlet beváltása</h2>
            </div>

        <div id="view-stats" style="display: none;">
            <h2>Statisztikák</h2>
            </div>

    </main>

    <footer>
        <p>&copy; <?= date('Y') ?> MoziBérlet App</p>
    </footer>

    <script src="m.js"></script>
</body>
</html>