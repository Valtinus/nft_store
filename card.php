<?php
session_start();
$cards = json_decode(file_get_contents('./data/cards.json'), true);
$users = json_decode(file_get_contents('./data/users.json'), true);


if (isset($_GET['id']) && isset($cards[$_GET['id']])) {
    $id = intval($_GET['id']);
} else {
    echo "Nincs ilyen kártya!";
    exit;
}

$color = "white";

if ($cards[$id]["rarity"] == "Legendary") {
    $color = "yellow";
} elseif($cards[$id]["rarity"] == "Epic") {
    $color = "purple";
} elseif($cards[$id]["rarity"] == "Rare") {
    $color = "blue";
} elseif($cards[$id]["rarity"] == "Uncommon") {
    $color = "emerald";
} elseif($cards[$id]["rarity"] == "Common") {
    $color = "lime";
}

$m = "0";
if($_SESSION['money'] >= 10000){
    $n = round($_SESSION['money'] / 1000, 1);
    $m = "{$n}K";
} else {
    $m = $_SESSION['money'];
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $cards[$id]['name']?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    

    <div class="bg-white">
        <header class="absolute inset-x-0 top-0 z-50">
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
            <h2 class="text-3xl font-semibold tracking-tight text-gray-900 sm:text-5xl">Is this the one for you?</h2>
        </div>
        <div class="px-8 flex flex-wrap -mb-4 justify-center">
            <img class="w-1/4 rounded-2xl border-4 border-<?= $color ?>-400" src="<?= $cards[$id]['image']?>" alt="<?= $cards[$id]['name']?>">
            <div>
                <div class="px-6 py-4">
                    <div class="font-bold text-4xl mb-2"><?= $cards[$id]['name']?></div>
                    <div class="font-bold text-2xl mb-4">Price: <?= $cards[$id]['price']?></div>
                    <p class="text-gray-700 text-base">
                        <?= $cards[$id]['description']?>
                    </p>
                </div>
                <div class="px-6 pt-4 pb-2">
                    <?php if($cards[$id]["rarity"] == "Legendary"):
                    ?>
                        <span class="inline-block bg-yellow-200 rounded-full px-3 py-1 text-sm font-semibold text-yellow-700 mr-2 mb-2"><?= $cards[$id]['rarity']?></span>
                    <?php elseif($cards[$id]["rarity"] == "Epic"):
                    ?>
                        <span class="inline-block bg-purple-200 rounded-full px-3 py-1 text-sm font-semibold text-purple-700 mr-2 mb-2"><?= $cards[$id]['rarity']?></span>
                    <?php elseif($cards[$id]["rarity"] == "Rare"):
                    ?>
                        <span class="inline-block bg-blue-200 rounded-full px-3 py-1 text-sm font-semibold text-blue-700 mr-2 mb-2"><?= $cards[$id]['rarity']?></span>
                    <?php elseif($cards[$id]["rarity"] == "Uncommon"):
                    ?>
                        <span class="inline-block bg-emerald-200 rounded-full px-3 py-1 text-sm font-semibold text-emerald-700 mr-2 mb-2"><?= $cards[$id]['rarity']?></span>
                    <?php elseif($cards[$id]["rarity"] == "Common"):
                    ?>
                        <span class="inline-block bg-lime-200 rounded-full px-3 py-1 text-sm font-semibold text-lime-700 mr-2 mb-2"><?= $cards[$id]['rarity']?></span>
                    <?php endif; ?>
                    <span class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2 mb-2"><?= $cards[$id]['family']?></span>                
                </div>
            </div>
        </div>
    </div>

</body>
</html>
