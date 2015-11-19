<?php

    require_once dirname(__DIR__) . '/vendor/autoload.php';
    use PhpAmqpLib\Connection\AMQPStreamConnection;
    $connection = new AMQPStreamConnection('localhost', 5672, 'guest', 'guest');
    $channel = $connection->channel();

    $channel->queue_declare('fila2', false, false, false, false);

    $callback = function($msg){
      echo " [x] Received ", $msg->body, "\n";
      sleep(substr_count($msg->body, '.'));
      echo " [x] Done", "\n";
      $msg->delivery_info['channel']->basic_ack($msg->delivery_info['delivery_tag']);
    };

    $channel->basic_qos(null, 1, null);
    $channel->basic_consume('task_queue', '', false, false, false, false, $callback);
?>
