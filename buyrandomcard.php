<?php
session_start();
$cards = json_decode(file_get_contents('./data/cards.json'), true);
$users = json_decode(file_get_contents('./data/users.json'), true);

if (!isset($_SESSION['loggedin']) || !$_SESSION['loggedin']) {
    header('Location: index.php');
    exit;
}
$user = $_SESSION['username'];

$cards_num = 0;
foreach($cards as $card) {
    if($card['owner'] == $_SESSION['username']) {
        $cards_num += 1;
    } 
}

function availableCard($card) {
    return ($card['owner'] == 'admin');
}

$availableCards = array_filter($cards, 'availableCard');


if ($_SESSION['username'] != 'admin') {
    if ($cards_num >= 5) {
        echo "You can't buy more NFT-s!";
    } elseif ($users[$_SESSION['username']]['money'] < 200) {
        echo "You don't have enough money to buy a random NFT!";
    } elseif (count($availableCards) > 0) {
        $randomCard = array_rand($availableCards, 1);

        $users[$_SESSION['username']]['money'] -= 200;

        $cards[$randomCard]['owner'] = $_SESSION['username'];

        file_put_contents('./data/cards.json', json_encode($cards, JSON_PRETTY_PRINT));
        file_put_contents('./data/users.json', json_encode($users, JSON_PRETTY_PRINT));

        echo "You bought a random NFT!";
    } else {
        echo "You couldn't buy a random NFT!";
    }
} else {
    echo "You can't do this!";
}

?>