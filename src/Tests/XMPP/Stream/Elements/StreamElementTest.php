<?php

use PHPUnit\Framework\TestCase;
use XMPP\Connection\Connection;
use XMPP\Stream\Elements\ElementInterface;
use XMPP\Stream\Elements\StreamElement;

class StreamElementTest extends TestCase
{
    /**
     * Setup variables and objects initialization
     */
    public function setUp()
    {
        $this->login   = 'cat@jabber.org';
        $this->host    = 'jabber.org';

        $this->streamOpening = "<?xml version='1.0'?>
    <stream:stream
        from='%s'
        to='%s'
        version='1.0'
        xml:lang='en'
        xmlns='jabber:client'
        xmlns:stream='http://etherx.jabber.org/streams'>";

        $this->connection = $this->getMockBuilder(Connection::class)
                             ->disableOriginalConstructor()
                             ->disableOriginalClone()
                             ->disableArgumentCloning()
                             ->getMock();

        $this->connection->method('getLogin')
                         ->willReturn($this->login);

         $this->connection->method('getHost')
                          ->willReturn($this->host);

        $this->streamElement = new StreamElement($this->connection);
    }

    /**
     * Test if appended successed
     */
    public function testAppendedStreamOpening()
    {
        $this->assertEquals(sprintf($this->streamOpening, $this->login, $this->host), $this->streamElement->getStreamOpening());
    }

    /**
     * Test if the XML of the opening stream is reseted
     */
    public function testResetStreamOpening()
    {
        $this->streamElement->resetStreamOpening();

        $this->assertEquals(sprintf($this->streamOpening, '__FROM__', '__TO__'), $this->streamElement->getStreamOpening());
    }

    /**
     * Test if connection has the Connection::class type
     */
    public function testConnectionType()
    {
        $this->assertInstanceOf(Connection::class, $this->streamElement->getConnection());
    }
}
