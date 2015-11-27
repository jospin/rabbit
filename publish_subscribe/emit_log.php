<?php

    require_once dirname(__DIR__) . '/vendor/autoload.php';
    use PhpAmqpLib\Connection\AMQPStreamConnection;
    use PhpAmqpLib\Message\AMQPMessage;

    $connection = new AMQPStreamConnection('localhost', 5672, 'guest', 'guest');
    $channel = $connection->channel();

    $channel->exchange_declare('logs', 'fanout', false, false, false);

    $data = implode(' ', array_slice($argv, 1));
    if(empty($data)) $data = "info: Hello Shift!";
    $msg = new AMQPMessage($data);

    $channel->basic_publish($msg, 'logs');

    echo " [x] Sent ", $data, "\n";

    $channel->close();
    $connection->close();

?>