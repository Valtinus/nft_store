<?php
session_start();
$cards = json_decode(file_get_contents('./data/cards.json'), true);
$users = json_decode(file_get_contents('./data/users.json'), true);

$errorMessage = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    $userFound = false;
    foreach ($users as $user) {
        if ($user['username'] === $username && password_verify($password, $user['password'])) {
            $userFound = true;
            break;
        }
    }

    if ($userFound) {
        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = $username;
        $_SESSION['money'] = $users[$username]['money'];

        header('Location: index.php');
        exit;
    } else {
        $errorMessage = 'Invalid email or password.';
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log in</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="style.css">
</head>
<body>
        <div class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8 pt-40">
            <div class="sm:mx-auto sm:w-full sm:max-w-sm">
            <?php if (!empty($errorMessage)): ?>
                <p class="p-3 text-center text-2xl font-bold leading-9 tracking-tight text-red-500"><?= htmlspecialchars($errorMessage) ?></p>
            <?php endif; ?>
                <a href="index.php">
                    <img class="mx-auto h-10 w-auto" src="./images/logo.png" alt="Your Company">
                </a>
                <h2 class="mt-10 text-center text-2xl font-bold leading-9 tracking-tight text-gray-900">Sign in to your account</h2>
            </div>

            <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
                <form class="space-y-6" action="#" method="POST">
                <div>
                    <label for="username" class="block text-sm font-medium leading-6 text-gray-900">Username</label>
                    <div class="mt-2">
                    <input id="username" name="username" type="text" value="<?= htmlspecialchars($username) ?>" autocomplete="username" required class="px-3 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-violet-600 sm:text-sm sm:leading-6">
                    </div>
                </div>

                <div>
                    <div class="flex items-center justify-between">
                    <label for="password" class="block text-sm font-medium leading-6 text-gray-900">Password</label>
                    <div class="text-sm">
                        <a href="#" class="font-semibold text-violet-600 hover:text-violet-500">Forgot password?</a>
                    </div>
                    </div>
                    <div class="mt-2">
                    <input id="password" name="password" type="password" autocomplete="current-password" required class="px-3 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-violet-600 sm:text-sm sm:leading-6">
                    </div>
                </div>

                <div>
                    <button type="submit" class="flex w-full justify-center rounded-md bg-violet-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-violet-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-violet-600">Sign in</button>
                </div>
                </form>

                <p class="mt-10 text-center text-sm text-gray-500">
                Not a member?
                <a href="register.php" class="font-semibold leading-6 text-violet-600 hover:text-violet-500">Sign up</a>
                </p>
            </div>
            </div>
  

    </div>
</body>
</html>