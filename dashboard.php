<?php
session_start();
$cards = json_decode(file_get_contents('./data/cards.json'), true);
$users = json_decode(file_get_contents('./data/users.json'), true);

if (!isset($_SESSION['loggedin']) || !$_SESSION['loggedin'] || !$_SESSION['isAdmin']) {
    header('Location: index.php');
    exit;
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="bg-white">
        <header class="absolute inset-x-0 top-0 z-50">
            <nav class="flex items-center justify-between p-6 lg:px-8" aria-label="Global">
            <div class="flex lg:flex-1">
                <a href="#" class="-m-1.5 p-1.5">
                <span class="sr-only">INFIMUM NFT</span>
                <img class="h-8 w-auto" src="./images/logo.png" alt="">
                </a>
            </div>
            <div class="lg:flex lg:gap-x-12">
                <a href="cards.php" class="text-sm font-semibold leading-6 text-gray-900">Marketplace</a>
                <?php if ($_SESSION['isAdmin']): ?>
                    <a href="dashboard.php" class="text-sm font-semibold leading-6 text-gray-900">Dashboard</a>
                <?php endif; ?>
            </div>
            <div class="lg:flex lg:flex-1 lg:justify-end">
                <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin']): ?>
                    <a href="user.php?username=<?= $_SESSION['username'] ?>" class="text-sm font-semibold leading-6 text-gray-900 mr-4">
                        <?= htmlspecialchars($_SESSION['username']) ?> - 
                        <?= $m ?> 💰
                    </a>
                    <a href="logout.php" class="text-sm font-semibold leading-6 text-violet-500">Log out</a>
                <?php else: ?>
                    <a href="login.php" class="text-sm font-semibold leading-6 text-violet-500">Log in</a>
                <?php endif; ?>
            </div>
            </nav>
        </header>
            <h1>Admin Dashboard</h1>

            <section>
                <h2>Kártyák Kezelése</h2>
                <table>
                    <!-- Kártyák listázása -->
                </table>
                <a href="add_card.php">Új Kártya Hozzáadása</a>
            </section>

            <section>
                <h2>Felhasználók Kezelése</h2>
                <table>
                    <!-- Felhasználók listázása -->
                </table>
            </section>
        </div>
</body>
</html>