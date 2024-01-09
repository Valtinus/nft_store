<?php
session_start();
$cards = json_decode(file_get_contents('./data/cards.json'), true);
$users = json_decode(file_get_contents('./data/users.json'), true);

if (!isset($_SESSION['loggedin']) || !$_SESSION['loggedin'] || !$_SESSION['isAdmin']) {
    header('Location: index.php');
    exit;
}

$m = "0";
if($_SESSION['money'] >= 10000){
    $n = round($_SESSION['money'] / 1000, 1);
    $m = "{$n}K";
} else {
    $m = $_SESSION['money'];
}

$errorMessage = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $rarity = $_POST['rarity'];
    $family = $_POST['family'];
    $price = $_POST['price'];
    $description = $_POST['description'];

    if (empty($name) || empty($rarity) || empty($family) || empty($price) || empty($description)) {
        $errorMessage = 'All fields are required.';
    } elseif (!is_numeric($price) || $price <= 0) {
        $errorMessage = 'Invalid price.';
    } elseif (array_key_exists($name, $cards)) {
        $errorMessage = 'This name already exists.';
    } else {
        if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
            $allowedTypes = array('image/jpeg', 'image/png');
            $fileType = $_FILES['image']['type'];
    
            if (in_array($fileType, $allowedTypes)) {
                $fileName = basename($_FILES['image']['name']);
                $imagePath = "./images/" . $fileName;
    
                if (move_uploaded_file($_FILES['image']['tmp_name'], $imagePath)) {
                    $id = count($cards);
                    $cards[$name] = [
                        'id' => strval($id),
                        'name' => $name,
                        'rarity' => $rarity,
                        'family' => $family,
                        'price' => $price,
                        'description' => $description,
                        'image' => $imagePath,
                        'owner' => "admin"
                    ];
    
                    file_put_contents('./data/cards.json', json_encode($cards, JSON_PRETTY_PRINT));
                } else {
                    echo "An error occured while uploading the file.";
                }
            } else {
                echo "Unsupported file.";
            }
        } else {
            echo "An error occured while uploading the file.";
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add NFT</title>
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
        

        <div class="text-center pb-10 px-6 pt-36 lg:px-8">
            <h2 class="text-3xl font-semibold tracking-tight text-gray-900 sm:text-5xl">Add new NFT</h2>
        </div>
        <?php if (!empty($errorMessage)): ?>
            <p class="p-3 text-center text-2xl font-bold leading-9 tracking-tight text-red-500"><?= htmlspecialchars($errorMessage) ?></p>
            <?php endif; ?>
        <div class="px-8 flex flex-wrap -mb-4 justify-center">
            <form action="addnft.php" method="post" enctype="multipart/form-data">
                <div class="grid grid-cols-1 gap-x-6 gap-y-4 sm:grid-cols-6">
                    <div class="sm:col-span-6">
                    <label for="name" class="block text-sm font-medium leading-6 text-gray-900" value="<?= htmlspecialchars($name) ?>">Name</label>
                    <div class="mt-2">
                        <div class="flex rounded-md shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-violet-600 sm:max-w-md">
                        <input type="text" name="name" id="name" autocomplete="name" class="block flex-1 border-0 bg-transparent py-1.5 p-2 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6" placeholder="Elon Musk" required>
                        </div>
                    </div>
                    </div>

                    <div class="col-span-full">
                    <label for="description" class="block text-sm font-medium leading-6 text-gray-900" value="<?= htmlspecialchars($description) ?>">Description</label>
                    <div class="mt-2">
                        <textarea id="description" name="description" rows="3" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-violet-600 sm:text-sm sm:leading-6 p-2" placeholder="Elon Musk is the head of SpaceX." required></textarea>
                    </div>
                    </div>

                    <div class="sm:col-span-6">
                    <label for="family" class="block text-sm font-medium leading-6 text-gray-900" value="<?= htmlspecialchars($family) ?>">Family</label>
                    <div class="mt-2">
                        <div class="flex rounded-md shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-violet-600 sm:max-w-md">
                        <input type="text" name="family" id="family" autocomplete="family" class="block flex-1 border-0 bg-transparent py-1.5 p-2 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6" placeholder="Alien" required>
                        </div>
                    </div>
                    </div>
                </div>


                <div class="mt-4 grid grid-cols-1 gap-x-6 gap-y-4 sm:grid-cols-6">

                    <div class="sm:col-span-3">
                    <label for="rarity" class="block text-sm font-medium leading-6 text-gray-900">Rarity</label>
                    <div class="mt-2">
                        <select id="rarity" name="rarity" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-violet-600 sm:max-w-xs sm:text-sm sm:leading-6" required>
                        <option>Common</option>
                        <option>Uncommon</option>
                        <option>Rare</option>
                        <option>Epic</option>
                        <option>Legendary</option>
                        </select>
                    </div>
                    </div>

                    

                    <div class="sm:col-span-3">
                    <label for="price" class="block text-sm font-medium leading-6 text-gray-900" value="<?= htmlspecialchars($price) ?>">Price</label>
                    <div class="mt-2">
                        <input type="number" name="price" id="price" autocomplete="price" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-violet-600 sm:text-sm sm:leading-6" required>
                    </div>
                    </div>

                    <div class="col-span-full">
                    <label for="cover-photo" class="block text-sm font-medium leading-6 text-gray-900">Cover photo</label>
                    <div class="mt-2 flex justify-center rounded-lg border border-dashed border-gray-900/25 px-6 py-10">
                        <div class="text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-300" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M1.5 6a2.25 2.25 0 012.25-2.25h16.5A2.25 2.25 0 0122.5 6v12a2.25 2.25 0 01-2.25 2.25H3.75A2.25 2.25 0 011.5 18V6zM3 16.06V18c0 .414.336.75.75.75h16.5A.75.75 0 0021 18v-1.94l-2.69-2.689a1.5 1.5 0 00-2.12 0l-.88.879.97.97a.75.75 0 11-1.06 1.06l-5.16-5.159a1.5 1.5 0 00-2.12 0L3 16.061zm10.125-7.81a1.125 1.125 0 112.25 0 1.125 1.125 0 01-2.25 0z" clip-rule="evenodd" />
                        </svg>
                        <div class="mt-4 flex text-sm leading-6 text-gray-600">
                            <label for="image" class="relative cursor-pointer rounded-md bg-white font-semibold text-violet-600 focus-within:outline-none focus-within:ring-2 focus-within:ring-violet-600 focus-within:ring-offset-2 hover:text-violet-500">
                            <span>Upload a file</span>
                            <input id="image" name="image" type="file" class="sr-only" required>
                            </label>
                            <p class="pl-1">or drag and drop</p>
                        </div>
                        <p class="text-xs leading-5 text-gray-600">PNG, JPG up to 10MB</p>
                        </div>
                    </div>
                    </div>
                </div>


                <div class="mt-6 flex items-center justify-end gap-x-6">
                    <button type="reset" class="text-sm font-semibold leading-6 text-gray-900">Cancel</button>
                    <button type="submit" class="rounded-md bg-violet-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-violet-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-violet-600">Save</button>
                </div>
            </div>

            </form>
        </div>
    </div>

</body>
</html>