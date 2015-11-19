<?php
	require_once dirname(__DIR__) . '/vendor/autoload.php';
	use PhpAmqpLib\Connection\AMQPStreamConnection;
	$connection = new AMQPStreamConnection('localhost', 5672, 'guest', 'guest');
	$channel = $connection->channel();

	$channel->queue_declare('fila1', false, false, false, false);

	echo ' [*] Aguardando pela mensagem.', "\n";

	$callback = function($msg) {
	  echo " [x] Recebido ", $msg->body, "\n";
	};

	$channel->basic_consume('fila1', '', false, true, false, false, $callback);

	while(count($channel->callbacks)) {
	    $channel->wait();
	}
?>