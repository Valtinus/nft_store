<?php
session_start();
$cards = json_decode(file_get_contents('./data/cards.json'), true);
$users = json_decode(file_get_contents('./data/users.json'), true);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cardId'])) {
    $cardId = $_POST['cardId'];

    if (isset($cards[$cardId]) && $cards[$cardId]['owner'] == $_SESSION['username']) {
        $salePrice = $cards[$cardId]['price'] * 0.9;
        $users[$_SESSION['username']]['money'] += $salePrice;

        $cards[$cardId]['owner'] = 'admin';

        file_put_contents('./data/cards.json', json_encode($cards, JSON_PRETTY_PRINT));
        file_put_contents('./data/users.json', json_encode($users, JSON_PRETTY_PRINT));

        echo "Successful sale!";
    } else {
        echo "The sale was unsuccessful!";
    }
} else {
    echo "An error occured!";
}
?>
