<?php

namespace XMPP\Connection;

/**
 * Class Client for connections
 *
 * @codeCoverageIgnore
 */
class ConnectionClient implements ConnectionClientInterface
{
    /**
     * @var int
     */
    const READ_BUFFER = 2048;

    /**
     * @var ressource
     */
    protected $connection;

    /**
     * @var ressource
     */
    protected $context;

    /**
     * Constructor
     *
     * @param ressource $context
     *
     * @return ClientConnection
     */
    public function __construct($context = null)
    {
        $this->connection = null;
        $this->context    = is_null($context) ? stream_context_create() : $context;
    }

    /**
     * {@inheritdoc}
     */
    public function connect($host, $port, $timeout, $flag)
    {
        $this->connection = stream_socket_client(sprintf('%s:%d', $host, $port),
                                                $errno,
                                                $errstr,
                                                $timeout,
                                                $flag,
                                                $this->context);

        if (!$this->connection) {
            return false;
        }

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function disconnect()
    {
        return fclose($this->connection);
    }

    /**
     * {@inheritdoc}
     */
    public function write($data)
    {
        return fwrite($this->connection, $data);
    }

    /**
     * {@inheritdoc}
     */
    public function read()
    {
        return fread($this->connection, self::READ_BUFFER);
    }

    /**
     * {@inheritdoc}
     */
    public function crypto($enable, $flag = STREAM_CRYPTO_METHOD_TLS_CLIENT)
    {
        return stream_socket_enable_crypto($this->connection, $enable, $flag);
    }

    /**
     * Check if here is an existing connection
     *
     * @return bool
     */
    public function isConnected()
    {
        return !is_null($this->connection);
    }
}
