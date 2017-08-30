<?php

use PHPUnit\Framework\TestCase;
use XMPP\Connection\Connection;
use XMPP\Connection\ConnectionClient;

class ConnectionTest extends TestCase
{
    /**
     * Setup variables and objects initialization
     */
    public function setUp()
    {
        $this->login   = 'cat@jabber.org';
        $this->host    = 'jabber.org';
        $this->port    = 5222;
        $this->timeout = 60*60;

        $this->connectionClient = $this->getMockBuilder(ConnectionClient::class)
                             ->disableOriginalConstructor()
                             ->disableOriginalClone()
                             ->disableArgumentCloning()
                             ->getMock();

        $this->connection = new Connection($this->connectionClient, $this->host, $this->port, $this->login, $this->timeout);
    }

    /**
     * Test conection Success
     */
    public function testConnect()
    {
        $this->connectionClient->method('connect')
                               ->willReturn(true);

        $isConnected = $this->connection->connect();

        $this->assertTrue($isConnected);
    }

    /**
     * Test connection failure
     *
     * @expectedException  XMPP\Exceptions\ConnectionException
     */
    public function testConnectFailure()
    {
        $this->connectionClient->method('connect')
                               ->willReturn(false);

        $this->connection->connect();
    }

    /**
     * Test disconnection success
     */
    public function testDisconnectSuccess()
    {
        $this->connectionClient->method('disconnect')
                               ->willReturn(true);

        $isConnected = $this->connection->disconnect();

        $this->assertTrue($isConnected);
    }

    /**
     * Test disconnection failure
     */
    public function testDisconnectFailure()
    {
        $this->connectionClient->method('disconnect')
                               ->willReturn(false);

        $isConnected = $this->connection->disconnect();

        $this->assertFalse($isConnected);
    }

    /**
     * Test sending datas success
     */
    public function testSendDataSuccess()
    {
        $bytes = 4;
        $this->connectionClient->method('write')
                               ->willReturn($bytes);

        $this->connectionClient->method('isConnected')
                               ->willReturn(true);

        $dataBytes = $this->connection->sendDatas("toto");

        $this->assertEquals($bytes, $dataBytes);
    }

    /**
     * Test sending datas failure when there is no connection initialized
     *
     * @expectedException XMPP\Exceptions\ConnectionException
     */
    public function testSendDataFailureWithoutExistingConnection()
    {
        $this->connectionClient->method('isConnected')
                               ->willReturn(false);

        $this->connection->sendDatas("toto");
    }

    /**
     * Test sending datas when there is problem when datas sent
     *
     * @expectedException XMPP\Exceptions\ConnectionException
     */
    public function testSendDataFailureWithWriteProblem()
    {
        $this->connectionClient->method('write')
                               ->willReturn(false);

        $this->connection->sendDatas("toto");
    }

    /**
     * Test reading datas success
     */
    public function testReadDataSuccess()
    {
        $response = 'response';
        $this->connectionClient->method('read')
                               ->willReturn($response);

        $this->connectionClient->method('isConnected')
                               ->willReturn(true);

        $responseData = $this->connection->getDatas();

        $this->assertEquals($response, $responseData);
    }

    /**
     * Test reading datas failure when there is no connection initialized
     *
     * @expectedException XMPP\Exceptions\ConnectionException
     */
    public function testReadDataFailureWithoutExistingConnection()
    {
        $this->connectionClient->method('isConnected')
                               ->willReturn(false);

        $this->connection->getDatas();
    }

    /**
     * Test reading datas when there is problem when datas sent
     *
     * @expectedException XMPP\Exceptions\ConnectionException
     */
    public function testReadDataFailureWithWriteProblem()
    {
        $this->connectionClient->method('read')
                               ->willReturn(false);

        $this->connection->getDatas();
    }

    /**
     * Test starting success crypto connection
     */
    public function testStartCrypto()
    {
        $this->connectionClient->method('crypto')
                               ->willReturn(true);

        $this->connectionClient->method('isConnected')
                               ->willReturn(true);

        $isTlsStarted = $this->connection->startTLS(true);

        $this->assertTrue($isTlsStarted);
    }

    /**
     * Test ending success crypto connection
     */
    public function testEndCrypto()
    {
        $this->connectionClient->method('crypto')
                               ->willReturn(false);

        $this->connectionClient->method('isConnected')
                               ->willReturn(true);

        $isTlsStarted = $this->connection->startTLS(false);

        $this->assertFalse($isTlsStarted);
    }

    /**
     * Test failing crypto connection
     *
     * @expectedException XMPP\Exceptions\ConnectionException
     */
    public function testCryptoFailureWithoutConnection()
    {
        $this->connectionClient->method('isConnected')
                               ->willReturn(false);

        $this->connection->startTls(true);
    }
}
