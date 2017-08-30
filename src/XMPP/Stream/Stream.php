<?php

namespace XMPP\Stream;

use XMPP\Connection\Connection;
use XMPP\Stream\Elements\StreamElement;
use XMPP\Stream\Elements\MechanismElement;
use XMPP\Stream\XML\StreamXML;

class Stream implements StreamInterface
{
    /**
     * @var Connection
     */
    protected $connection;

    /**
     * @var StreamElement
     */
    protected $streamElement;

    /**
     * @var MechanismElement
     */
    protected $mechanisms;

    /**
     * @var StreamXML;
     */
     protected $streamXML;

    /**
     * {@inheritdoc}
     */
    public function __construct(StreamElement $streamElement, MechanismElement $mechanismElement, StreamXML $streamXML)
    {
        $this->streamElement = $streamElement;
        $this->mechanisms    = $mechanismElement;
        $this->streamXML     = $streamXML;
        $this->connection    = $streamElement->getConnection();

        $this->connection->connect();
    }

    /**
     * Destructor
     */
    public function __destruct()
    {
        $this->connection->disconnect();
    }

    /**
     * Engage a XMPP connection
     *
     * @return string
     */
    public function engageFlow()
    {
        $this->connection->sendDatas($this->streamElement->getStreamOpening());
        $responseDatas = $this->connection->getDatas();

        $this->streamXML->parseXML($responseDatas.StreamElement::END_STREAM);
        echo "C : ".$this->streamElement->getStreamOpening()."\n";
        echo 'S : '.$responseDatas."\n\n";

        if ($this->streamXML->isTLSRequired()) {
            $this->connection->sendDatas(StreamElement::TEMPLATE_NEGOCIATE_TLS);
            echo "C : ".StreamElement::TEMPLATE_NEGOCIATE_TLS."\n";
            echo 'S : '.$this->connection->getDatas()."\n\n";

            $this->connection->startTLS(true);

            $this->connection->sendDatas($this->streamElement->getStreamOpening());
            $responseDatas = $this->connection->getDatas();
            $this->streamXML->parseXML($responseDatas.StreamElement::END_STREAM);
            echo "C : ".$this->streamElement->getStreamOpening()."\n";
            echo 'S : '.$responseDatas."\n\n";

        }

        $this->mechanisms->setMechanisms($this->streamXML->getMechanisms());

        var_dump($this->mechanisms->getMechanisms());
    }
}
