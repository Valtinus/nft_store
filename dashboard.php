<?php
session_start();
$cards = json_decode(file_get_contents('./data/cards.json'), true);
$users = json_decode(file_get_contents('./data/users.json'), true);

if (!isset($_SESSION['loggedin']) || !$_SESSION['loggedin'] || !$_SESSION['isAdmin']) {
    header('Location: index.php');
    exit;
}

$m = "0";
$full = 0;
foreach($users as $user) {
    if($user['username'] == $_SESSION['username']) {
        if($user['money'] >= 10000) {
            $n = round($user['money'] / 1000, 1);
            $m = "{$n}K";
            $full = $user['money'];
        } else {
            $full = $user['money'];
            $m = $user['money'];
        }
    }
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
        <header class="fixed inset-x-0 top-0 z-50 shadow-md bg-white">
            <nav class="flex items-center justify-between p-6 lg:px-8" aria-label="Global">
            <div class="flex lg:flex-1">
                <a href="index.php" class="-m-1.5 p-1.5">
                <span class="sr-only">INFIMUM NFT</span>
                <img class="h-8 w-auto" src="./images/logo.png" alt="">
                </a>
            </div>
            <div class="lg:flex lg:gap-x-12">
                <a href="cards.php" class="text-sm font-semibold leading-6 text-gray-900">Marketplace</a>
                <?php if ($_SESSION['isAdmin']): ?>
                    <a href="dashboard.php" class="text-sm font-bold leading-6 text-gray-900">Dashboard</a>
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
        <div class="text-center pb-14 px-6 pt-36 lg:px-8">
            <h2 class="text-3xl font-semibold tracking-tight text-gray-900 sm:text-5xl">Admin dashboard</h2>
        </div>
        <div class="px-8 flex flex-row flex-wrap -mb-4 justify-center">
            <div class="w-1/3 mx-10 min-w-min">
                <div class="flex text-xl font-semibold tracking-tight text-gray-900 sm:text-xl justify-between px-5"><p class="flex">NFT-s</p><a href="addnft.php" class="flex w-24 justify-center rounded-md bg-violet-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-violet-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-violet-600">Add</a></div>
                
                <ul role="list">
                    <?php 
                        $cards_reverse = array_reverse($cards);
                        foreach ($cards_reverse as $card): ?>
                    <li class="flex justify-between gap-x-6 p-5 border-2 rounded-3xl my-2 items-center">
                        <div class="flex min-w-0 gap-x-4">
                        <a href="card.php?id=<?= $card['name'] ?>">
                            <img class="h-12 w-12 flex-none rounded-2xl bg-gray-50" src="<?= $card['image']?>" alt="">
                        </a>
                        <div class="min-w-0 flex-auto">
                            <p class="text-sm font-semibold leading-6 text-gray-900"><?= $card['name'] ?> - ID: <?= $card['id'] ?></p>
                            <p class="mt-1 truncate text-xs leading-5 text-gray-500">Price: <?= $card['price'] ?></p>
                        </div>
                        </div>
                        <div class="hidden shrink-0 sm:flex sm:flex-col">
                            <?php if($card['owner'] == "admin"): ?>
                                <a href="editcard.php?id=<?= $card['name'] ?>" class="flex w-24 justify-center rounded-md bg-violet-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-violet-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-violet-600">Edit</a>
                            <?php else: ?>
                                <a class="flex w-24 justify-center rounded-md bg-violet-300 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-violet-200 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-violet-300">Edit</a>
                            <?php endif; ?>
                        </div>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <div class="w-1/3 mx-10 min-w-min">
                <div class="flex text-xl font-semibold tracking-tight text-gray-900 sm:text-xl justify-between px-5"><p class="flex">Users</p></div>
                
                <ul role="list">
                    <?php foreach($users as $user): ?>
                    <li class="flex justify-between gap-x-6 p-5 border-2 rounded-3xl my-2 items-center">
                        <div class="flex min-w-0 gap-x-4">
                        <div class="min-w-0 flex-auto">
                            <p class="text-sm font-semibold leading-6 text-gray-900"><?= $user['username'] ?></p>
                            <p class="mt-1 truncate text-xs leading-5 text-gray-500">Email: <?= $user['email'] ?></p>
                        </div>
                        </div>
                        <div class="hidden shrink-0 sm:flex sm:flex-col sm:items-end">
                            <p class="text-sm leading-6 text-gray-900">Balance: <?= $user['money'] ?></p>
                            <p class="mt-1 text-xs leading-5 text-gray-500">Title: 
                                <?php if($user['isAdmin']): ?>
                                    Admin
                                <?php else: ?>
                                    User
                                <?php endif; ?>
                                </p>
                        </div>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>
</body>
</html>