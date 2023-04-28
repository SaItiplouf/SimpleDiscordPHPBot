<?php
require_once('./vendor/autoload.php');
// require('./key.php');
$key = 'token';

use Discord\Discord;
use Discord\Parts\Channel\Message;
use Discord\Parts\Channel\MessageReaction;
use Discord\WebSockets\Event;
use Discord\WebSockets\Intents;
use Discord\Parts\User\User;
use Discord\Parts\Channel\ReactionEmoji;



// Protection API
$counter = 0;
$maxRequests = 25; 
$resetInterval = 60; 


$discord = new Discord([
    'token' => $key,
    'intents' => [
        Intents::GUILDS,
        Intents::GUILD_MESSAGES,
        Intents::GUILD_MESSAGE_REACTIONS
    ]
]);

$discord->on('ready', function ($discord) {
    $guilds = $discord->guilds;
    foreach ($guilds as $guild) {
        $systemChannelId = $guild->system_channel_id;
        if (!empty($systemChannelId)) {
            $systemChannel = $discord->getChannel($systemChannelId);
            $discord->loop->addPeriodicTimer(120, function () use ($systemChannel) {
                $systemChannel->sendMessage('@everyone message périodique');
            });
        }
    }
});



$discord->on(Event::MESSAGE_CREATE, function (Message $message, Discord $discord) {

    // Récupère le contenu du message
    $content = $message->content;

    // Vérifie le compteur avant d'effectuer une requête
    global $counter, $maxRequests, $resetInterval;
    if ($counter < $maxRequests) {
        if (strpos($content, 'Peche') === 0) {
            // Envoie une réponse
            $message->channel->sendMessage('```La Pêche Mel Bush est un cocktail originaire des fêtes estudiantines wallonnes du début des années 90 constitué d une Pêcheresse mélangée avec une Bush ambrée``` https://img.saveur-biere.com/img/p/1677-62934.jpg');
        }
        if (strpos($content, 'Ping') === 0) {
            // Envoie une réponse
            $message->channel->sendMessage('Pong');
        }

        if (strpos($content, 'zzz') === 0) {
            // Envoie une réponse
            $message->channel->sendMessage('rompish');
        }
        if (strpos($content, 'pion') === 0) {
            // Envoie une réponse
            $message->channel->sendMessage('pion');
        }


        $author = $message->member->nick ?? $message->author->username;

        if (strpos($author, 'Alexandre') === 0) {
            // Ajoute une réaction au message
            $message->react('👍');
            sleep(1);
            $message->channel->sendMessage('Test');
        }
        // Incrémente le compteur
        $counter++;
    } else {
        // Attend le temps de réinitialisation
        sleep($resetInterval);

        // Réinitialise le compteur
        global $counter;
        $counter = 0;
    }
});

$discord->on(Event::MESSAGE_REACTION_ADD, function (\Discord\Parts\WebSockets\MessageReaction $reaction, Discord $discord) {
    // Vérifie si la réaction est un pouce levé
    if ($reaction->emoji->name == '👍') {
        // Récupère le message d'origine
        $message = $reaction;

        $botId = INSERT_BOT_ID;
        if ($reaction->user_id == $botId) {
            return;
        }
        // Envoie un message
        $message->channel->sendMessage('+1');
    }
});

$discord->on(Event::MESSAGE_REACTION_REMOVE, function (\Discord\Parts\WebSockets\MessageReaction $reaction, Discord $discord) {
    // Vérifie si la réaction est un pouce levé
    if ($reaction->emoji->name == '👍') {
        // Récupère le message d'origine
        $message = $reaction;

        $botId = INSERT_BOT_ID;
        if ($reaction->user_id == $botId) {
            return;
        }
        // Envoie un message
        $message->channel->sendMessage('-1');
    }
});



$discord->on('ready', function (Discord $discord) {
    for ($i = 1; $i <= 20; $i++) {
        echo " \n";
    }
    echo "                /|  /|  ---------------------------\n";
    echo "                ||__||  |                         |\n";
    echo "               /   O O\__      Bot ready          |\n";
    echo "              /          \         By Polo        |\n";
    echo "             /      \     \                       |\n";
    echo "            /   _    \     \ ----------------------\n";
    echo "           /    |\____\     \      ||\n";
    echo "          /     | | | |\____/      ||\n";
    echo "         /       \| | | |/ |     __||\n";
    echo "        /  /  \   -------  |_____| ||\n";
    echo "       /   |   |           |       --|\n";
    echo "       |   |   |           |_____  --|\n";
    echo "       |  |_|_|_|          |     \----\n";
    echo "       /\                  |\n";
    echo "      / /\        |        /\n";
    echo "     / /  |       |       |\n";
    echo " ___/ /   |       |       |\n";
    echo "|____/    c_c_c_C/ \C_c_c_c\n";
    for ($i = 1; $i <= 5; $i++) {
        echo " \n";
    }
});

$discord->run();

?>