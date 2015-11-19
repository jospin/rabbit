<?
    require_once dirname(__DIR__) . '/vendor/autoload.php';
    use PhpAmqpLib\Connection\AMQPStreamConnection;
    use PhpAmqpLib\Message\AMQPMessage;
    $connection = new AMQPStreamConnection('localhost', 5672, 'guest', 'guest');
    $channel = $connection->channel();

    $channel->queue_declare('fila2', false, false, false, false);

    $data = implode(' ', array_slice($argv, 1));
    if(empty($data)) $data = "Hello World!";
    $msg = new AMQPMessage($data,
                            array('delivery_mode' => 2) # make message persistent
                          );

    $channel->basic_publish($msg, '', 'task_queue');

    echo " [x] Sent ", $data, "\n";