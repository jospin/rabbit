<?php
	require_once dirname(__DIR__) . '/vendor/autoload.php';
	use PhpAmqpLib\Connection\AMQPStreamConnection;
	use PhpAmqpLib\Message\AMQPMessage;

	$connection = new AMQPStreamConnection('localhost', 5672, 'guest', 'guest');
	$channel = $connection->channel();

	$channel->queue_declare('fila1', false, false, false, false);
	$message = 'Teste de envio 1 para1';
	$msg = new AMQPMessage($message);
	$channel->basic_publish($msg, '', 'fila1');

	echo " [x] Enviado '{$message}'\n";

	$channel->close();
	$connection->close();
?>
