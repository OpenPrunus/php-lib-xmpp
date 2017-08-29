<?php

namespace XMPP\Connection;

use XMPP\Exceptions\ConnectionException;

/**
 * Class for manage XMPP connections
 */
class Connection implements ConnectionInterface
{
    /**
     * @var string
     */
    protected $host;

    /**
     * @var int
     */
    protected $port;

    /**
     * @var int
     */
    protected $timeout;

    /**
     * @var bool
     */
    protected $tls;

    /**
     * @var XMPP\Connection\ClientConnection
     */
    protected $client;

    /**
     * Constructor
     *
     * @param ConnectionClientInterface $client
     * @param string $host
     * @param int $port
     * @param int $timeout
     */
    public function __construct(ConnectionClientInterface $client, $host, $port, $timeout)
    {
        $this->tls        = false;
        $this->host       = $host;
        $this->port       = $port;
        $this->timeout    = $timeout;
        $this->client     = $client;
    }

    /**
     * {@inheritdoc}
     */
    public function connect($flag = STREAM_CLIENT_CONNECT)
    {
        $isConnected = $this->client->connect($this->host, $this->port, $this->timeout, $flag);

        if (!$isConnected) {
            throw new ConnectionException(sprintf("Failure to connect to %s on port %d", $this->host, $this->port));
        }

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function disconnect()
    {
        return $this->client->disconnect();
    }

    /**
     * {@inheritdoc}
     */
    public function sendDatas($data)
    {
        self::isNotConnectedThrowsException();

        $numberBytes = $this->client->write($data);

        if (!$numberBytes) {
            throw new ConnectionException("An error was encoured when sending datas");
        }

        return $numberBytes;
    }

    /**
     * {@inheritdoc}
     */
    public function getDatas()
    {
        self::isNotConnectedThrowsException();

        $recoveredDatas = $this->client->read();

        if (!$recoveredDatas) {
            throw new ConnectionException("An error was encoured when recovered datas");
        }

        return $recoveredDatas;
    }

    /**
     * Start a TLS connection
     *
     * @param bool $enable
     *
     * @return bool
     */
    public function startTLS($enable)
    {
        self::isNotConnectedThrowsException();

        $this->tls = $enable;

        return $this->client->crypto($enable);
    }

    /**
     * Throws exception if there isn't existing connection
     *
     * @return void
     *
     * @throws XMPP\Exceptions\ConnectionException
     */
    private function isNotConnectedThrowsException()
    {
        if (!$this->client->isConnected()) {
            throw new ConnectionException("No existing connection");
        }
    }
}
