<?php

namespace XMPP\Stream\Elements;

use XMPP\Connection\Connection;

/**
 * StreamElement model class
 *
 * @codeCoverageIgnore
 */
class StreamElement implements ElementInterface
{
    /**
    * @var Connection
    */
    protected $connection;

    /**
    * @var string
    */
    protected $from;

    /**
    * @var string
    */
    protected $to;

    /**
     * @var string
     */
    const FROM = "__FROM__";

    /**
     * @var string
     */
    const TO = "__TO__";

    /**
     * @var string
     */
    const TEMPLATE_STREAM_OPENING = "<?xml version='1.0'?>
    <stream:stream
        from='__FROM__'
        to='__TO__'
        version='1.0'
        xml:lang='en'
        xmlns='jabber:client'
        xmlns:stream='http://etherx.jabber.org/streams'>";

    /**
     * @var string
     */
    const TEMPLATE_NEGOCIATE_TLS = "<starttls xmlns='urn:ietf:params:xml:ns:xmpp-tls'/>";

    /**
     * @var string
     */
    const END_STREAM = "</stream:stream>";

    /**
     * @var string
     */
    protected $streamOpening;

    /**
     * Constructor
     *
     * @param string $from
     * @param string $to
     *
     * @return StreamElement
     */
    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
        $this->from       = $connection->getLogin();
        $this->to         = $connection->getHost();
        $this->appendStreamOpening();
    }

    /**
     * Get XML stream opening
     *
     * @return string
     */
    public function getStreamOpening()
    {
        return $this->streamOpening;
    }

    /**
     * Reset stream opening template
     *
     * @return StreamElement
     */
    public function resetStreamOpening()
    {
        $this->streamOpening = self::TEMPLATE_STREAM_OPENING;

        return $this;
    }

    /**
     * Get connection object
     *
     * @return Connection
     */
    public function getConnection()
    {
        return $this->connection;
    }

    /**
     * Append stream opening template
     */
    public function appendStreamOpening()
    {
        $this->streamOpening = str_replace(self::FROM, $this->from, self::TEMPLATE_STREAM_OPENING);
        $this->streamOpening = str_replace(self::TO, $this->to, $this->streamOpening);
    }
}
