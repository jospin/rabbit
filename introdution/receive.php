<?php

	require_once dirname(__DIR__) . '/vendor/autoload.php';
	use PhpAmqpLib\Connection\AMQPStreamConnection;

	//AMQPStreamConnection faz a conexão passando host porta usuario e senha 
	$connection = new AMQPStreamConnection('localhost', 5672, 'guest', 'guest');
	// Criamos um canal
	$channel = $connection->channel();
	//Declaramos uma queue, e nomeamos ela.
	$channel->queue_declare('fila1', false, false, false, false);

	echo ' [*] Aguardando pela mensagem.', "\n";
	//Criamos a finção de callback para aguardar o envio
	$callback = function($msg) {
	  echo " [x] Recebido ", $msg->body, "\n";
	};

	// Consome a fila1 passando a função de callback
	$channel->basic_consume('fila1', '', false, true, false, false, $callback);

	// Looping para ficar buscando na queue
	while(count($channel->callbacks)) {
	    $channel->wait();
	}
?>