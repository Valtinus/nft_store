<?php
session_start();
$cards = json_decode(file_get_contents('./data/cards.json'), true);
$users = json_decode(file_get_contents('./data/users.json'), true);


if (isset($_GET['username']) && isset($users[$_GET['username']])) {
    $id = $_GET['username'];
} else {
    echo "This user does not exist!";
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
    <title><?= $users[$id]['username'] ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    

    <div class="bg-white">
        <header class="fixed inset-x-0 top-0 z-50 shadow-md bg-white">
            <nav class="flex items-center justify-between p-6 lg:px-8" aria-label="Global">
            <div class="flex lg:flex-1">
                <a href="index.php"  class="-m-1.5 p-1.5">
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
                    <a href="#" class="text-sm font-semibold leading-6 text-gray-900 mr-4">
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
            <h2 class="text-3xl font-semibold tracking-tight text-gray-900 sm:text-5xl">User information</h2>
        </div>
        <div class="px-8 flex-col flex-wrap -mb-4 text-center">
            <p class="text-xl font-semibold tracking-tight text-gray-900 sm:text-xl">Username: <?= htmlspecialchars($_SESSION['username']) ?></p>
            <p class="text-xl font-semibold tracking-tight text-gray-900 sm:text-xl">Balance: <?= $full ?> 💰</p>
            <p class="text-xl font-semibold tracking-tight text-gray-900 sm:text-xl">Email: <?= htmlspecialchars($_SESSION['email']) ?></p>
            <p class="text-3xl font-semibold tracking-tight text-gray-900 sm:text-3xl pt-20 pb-5">Your NFT-s:
                <div class="px-8 flex flex-wrap -mb-4 justify-center">
                    <?php
                        $cards_reverse = array_reverse($cards);
                        foreach ($cards_reverse as $card):
                            if($card['owner'] == $_SESSION['username']){
                    ?>
                    <a href="card.php?id=<?= $card['name'] ?>">
                        <div class="mx-3 max-w-56 rounded overflow-hidden shadow-lg mb-4 card">
                            <img class="w-full" src="<?= $card['image']?>" alt="<?= $card['name']?>">
                            <div class="px-6 py-4">
                                <div class="font-bold text-xl mb-2"><?= $card['name']?></div>
                                <div class="font-bold text-l mb-4">Price: <?= $card['price']?></div>
                                <p class="text-gray-700 text-base">
                                    <?= $card['description']?>
                                </p>
                            </div>
                            <div class="px-6 pt-4 pb-2">
                                <?php if($card["rarity"] == "Legendary"):
                                ?>
                                    <span class="inline-block bg-yellow-200 rounded-full px-3 py-1 text-sm font-semibold text-yellow-700 mr-2 mb-2"><?= $card['rarity']?></span>
                                <?php elseif($card["rarity"] == "Epic"):
                                ?>
                                    <span class="inline-block bg-purple-200 rounded-full px-3 py-1 text-sm font-semibold text-purple-700 mr-2 mb-2"><?= $card['rarity']?></span>
                                <?php elseif($card["rarity"] == "Rare"):
                                ?>
                                    <span class="inline-block bg-blue-200 rounded-full px-3 py-1 text-sm font-semibold text-blue-700 mr-2 mb-2"><?= $card['rarity']?></span>
                                <?php elseif($card["rarity"] == "Uncommon"):
                                ?>
                                    <span class="inline-block bg-emerald-200 rounded-full px-3 py-1 text-sm font-semibold text-emerald-700 mr-2 mb-2"><?= $card['rarity']?></span>
                                <?php elseif($card["rarity"] == "Common"):
                                ?>
                                    <span class="inline-block bg-lime-200 rounded-full px-3 py-1 text-sm font-semibold text-lime-700 mr-2 mb-2"><?= $card['rarity']?></span>
                                <?php endif; ?>
                                <span class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2 mb-2"><?= $card['family']?></span>                
                            </div>
                        </div>
                    </a>
                    <?php $i++; } endforeach; ?>
                </div>
            </p>
        </div>
    </div>

</body>
</html>
