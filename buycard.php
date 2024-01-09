<?php
session_start();
$cards = json_decode(file_get_contents('./data/cards.json'), true);
$users = json_decode(file_get_contents('./data/users.json'), true);

$cards_num = 0;
foreach($cards as $card) {
    if($card['owner'] == $_SESSION['username']) {
        console.log($cards_num);
        $cards_num += 1;
    } 
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cardId'])) {
    $cardId = $_POST['cardId'];

    if($cards[$cardId]['owner'] != 'admin') {
        echo "You can't buy this NFT!";
    } elseif ($cards_num >= 5) {
        echo "You can't buy more NFT-s!";
    } elseif ($users[$_SESSION['username']]['money'] < $cards[$cardId]['price']) {
        echo "You don't have enough money to buy this NFT!";
    } elseif (isset($cards[$cardId]) && $cards[$cardId]['owner'] !=  $_SESSION['username']) {
        $users[$_SESSION['username']]['money'] -= $cards[$cardId]['price'];

        $cards[$cardId]['owner'] = $_SESSION['username'];

        file_put_contents('./data/cards.json', json_encode($cards, JSON_PRETTY_PRINT));
        file_put_contents('./data/users.json', json_encode($users, JSON_PRETTY_PRINT));

        echo "You bought this NFT!";
    } else {
        echo "You couldn't buy this NFT!";
    }
} else {
    echo "An error occured!";
}
?>
