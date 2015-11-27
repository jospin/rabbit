<?php

	// Send.php
	require_once dirname(__DIR__) . '/vendor/autoload.php';
	use PhpAmqpLib\Connection\AMQPStreamConnection;
	use PhpAmqpLib\Message\AMQPMessage;

	//AMQPStreamConnection faz a conexão passando host porta usuario e senha 
	$connection = new AMQPStreamConnection('localhost', 5672, 'guest', 'guest');
	// Criamos um canal
	$channel = $connection->channel();

	//Declaramos uma queue, e nomeamos ela.
	$channel->queue_declare('fila1', false, false, false, false);
	$message = 'Teste de envio 1 para1';
	// Cria a mensagem como um array de bytes, podendo assim colocar o que precisar.
	$msg = new AMQPMessage($message);
	// Envia para a queue nomeada no caso fila1
	$channel->basic_publish($msg, '', 'fila1');

	echo " [x] Enviado '{$message}'\n";

	// É importante após enviar liberar a conexão e o canal.
	$channel->close();
	$connection->close();
?>
