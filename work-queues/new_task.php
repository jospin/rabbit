<?
    require_once dirname(__DIR__) . '/vendor/autoload.php';
    use PhpAmqpLib\Connection\AMQPStreamConnection;
    use PhpAmqpLib\Message\AMQPMessage;
    //AMQPStreamConnection faz a conexão passando host porta usuario e senha 
    $connection = new AMQPStreamConnection('localhost', 5672, 'guest', 'guest');
    // Criamos um canal
    $channel = $connection->channel();
    //Declaramos uma queue, e nomeamos ela.
    $channel->queue_declare('fila2', false, true, false, false);
    // Permite passar a mensagem pela linha de comando
    $data = implode(' ', array_slice($argv, 1));
    if(empty($data)) $data = "Hello World!";
    $msg = new AMQPMessage($data,
                            array('delivery_mode' => 2) # make message persistent
                          );

    $channel->basic_publish($msg, '', 'fila2');

    echo " [x] Sent ", $data, "\n";

$channel->close();
$connection->close();

