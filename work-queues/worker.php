<?php

    require_once dirname(__DIR__) . '/vendor/autoload.php';
    use PhpAmqpLib\Connection\AMQPStreamConnection;
    //AMQPStreamConnection faz a conexão passando host porta usuario e senha 
    $connection = new AMQPStreamConnection('localhost', 5672, 'guest', 'guest');
    // Criamos um canal
    $channel = $connection->channel();
    //Declaramos uma queue, e nomeamos ela.
    $channel->queue_declare('fila2', false, true, false, false);
    //Criamos a finção de callback para aguardar o envio
    $callback = function($msg){
        echo " [x] Received ", $msg->body, "\n";
        sleep(substr_count($msg->body, '.')); // Sleep para simular o carregamento
        echo " [x] Done", "\n";
        $msg->delivery_info['channel']
            ->basic_ack($msg->delivery_info['delivery_tag']); //Envio do ACK
    };

    $channel->basic_qos(null, 1, null);
    // Consome a fila1 passando a função de callback 4º parâmetro false envia ack
    $channel->basic_consume('fila2', '', false, false, false, false, $callback);

    // Looping para ficar buscando na queue
    while(count($channel->callbacks)) {
        $channel->wait();
    }

    $channel->close();
    $connection->close();

?>