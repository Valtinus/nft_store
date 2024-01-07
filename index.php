<?php
session_start();
$cards = json_decode(file_get_contents('./data/cards.json'), true);
$users = json_decode(file_get_contents('./data/users.json'), true);

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
    <title>INFIMUM NFT</title>
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
        
        <div class="relative isolate px-6 pt-14 lg:px-8">
            <div class="absolute inset-x-0 -top-40 -z-10 transform-gpu overflow-hidden blur-3xl sm:-top-80" aria-hidden="true">
            <div class="relative left-[calc(50%-11rem)] aspect-[1155/678] w-[36.125rem] -translate-x-1/2 rotate-[30deg] bg-gradient-to-tr from-[#ff80b5] to-[#9089fc] opacity-30 sm:left-[calc(50%-30rem)] sm:w-[72.1875rem]" style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)"></div>
            </div>
            <div class="mx-auto max-w-2xl py-32 sm:py-48 lg:py-56">
            
            <div class="text-center">
                <h1 class="text-4xl font-semibold tracking-tight text-gray-900 sm:text-6xl">Buy and trade NFT-s with <span class="font-extrabold">zero effort</span></h1>
                <p class="mt-6 text-lg leading-8 text-gray-600">INFIMUM is the safest and simplest platform for you to start your NFT journey. Are you ready?</p>
                <div class="mt-10 flex items-center justify-center gap-x-6">
                <a href="login.php" class="rounded-md bg-violet-600 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-violet-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-violet-600">Start trading</a>
                <a href="cards.php" class="text-sm font-semibold leading-6 text-gray-900">View NFT-s</a>
                </div>
            </div>
            </div>
            <div class="absolute inset-x-0 top-[calc(100%-13rem)] -z-10 transform-gpu overflow-hidden blur-3xl sm:top-[calc(100%-30rem)]" aria-hidden="true">
            <div class="relative left-[calc(50%+3rem)] aspect-[1155/678] w-[36.125rem] -translate-x-1/2 bg-gradient-to-tr from-[#ff80b5] to-[#9089fc] opacity-30 sm:left-[calc(50%+36rem)] sm:w-[72.1875rem]" style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)"></div>
            </div>
        </div>

        <div class="text-center pb-14">
            <h2 class="text-3xl font-semibold tracking-tight text-gray-900 sm:text-5xl">Browse the NFT market</h2>
        </div>
        <div class="px-8 flex flex-wrap -mb-4 justify-center">
            <?php 
                shuffle($cards);
                foreach ($cards as $card):
                    if($i > 5) {break;} else {
            ?>
            <a href="card.php?id=<?= $card['id'] ?>">
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



         

        

    </div>
    <script>

    </script>
</body>
</html>
