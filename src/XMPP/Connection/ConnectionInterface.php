<?php

namespace XMPP\Connection;

interface ConnectionInterface
{
    /**
     * Start a connection to host
     *
     * @return bool
     *
     * @throws Exceptions\ConnectionException
     */
    public function connect();

    /**
     * Close a connection to host
     *
     * @return bool
     */
    public function disconnect();

    /**
     * Data format XML to send and returns the number of bytes written
     *
     * @param string data
     *
     * @return int
     *
     * @throws Exceptions\ConnectionException
     */
    public function sendDatas($data);

    /**
     * Recover datas
     *
     * @return string
     *
     * @throws Exceptions\ConnectionException
     */
    public function getDatas();
}
