<?php

namespace XMPP\Connection;

interface ConnectionClientInterface
{
    /**
     * Connect to server
     *
     * @param string $host
     * @param int    $port
     * @param int    $timeout
     * @param int    $flag
     *
     * @return bool
     */
    public function connect($host, $port, $timeout, $flag);

    /**
     * Close connection
     *
     * @return bool
     */
    public function disconnect();

    /**
     * Write data
     *
     * @param string $data
     *
     * @return int|false
     */
    public function write($data);

    /**
     * Get data
     *
     * @return string|false
     */
    public function read();

    /**
     * Enable/Disable crypto
     *
     * @param bool $enable
     * @param int  $flag
     *
     * @return bool
     */
    public function crypto($enable, $flag);
}
