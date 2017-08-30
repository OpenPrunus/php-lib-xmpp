<?php

require_once 'bootstrap.php';

use XMPP\Connection\Connection;
use XMPP\Connection\ConnectionClient;
use XMPP\Stream\Elements\StreamElement;
use XMPP\Stream\Elements\MechanismElement;
use XMPP\Stream\Stream;
use XMPP\Stream\XML\StreamXML;
use XMPP\Stream\XML\StreamXMLClient;

$login = 'toto@toto.to';
$host = 'toto.to';
$port = 5222;

$connectionClient = new ConnectionClient(stream_context_create(['ssl' => ['verify_peer' => false]]));
$connection       = new Connection($connectionClient, $host, $port, $login);
$streamElement    = new StreamElement($connection);
$mechanismElement = new MechanismElement();
$streamXMLClient  = new StreamXMLClient();
$streamXML        = new StreamXML($streamXMLClient);
$stream           = new Stream($streamElement,$mechanismElement, $streamXML);

$stream->engageFlow();
