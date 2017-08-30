<?php

use PHPUnit\Framework\TestCase;
use XMPP\Stream\XML\StreamXML;
use XMPP\Stream\XML\StreamXMLClient;

class StreamXMLTest extends TestCase
{
    /**
     * Setup variables and objects initialization
     */
    public function setUp()
    {
        $this->streamXMLClient = $this->getMockBuilder(StreamXMLClient::class)
                             ->disableOriginalConstructor()
                             ->disableOriginalClone()
                             ->disableArgumentCloning()
                             ->getMock();

        $this->xml = "<?xml version='1.0'?><foo><bar>%s</bar></foo>";

        $this->streamXML = new StreamXML($this->streamXMLClient);
    }

    public function testParseXML()
    {
        $string = 'TEST';
        $this->xml = sprintf($this->xml, $string);

        $this->streamXMLClient->method('parseXML')
                               ->willReturn(new \simpleXMLElement($this->xml));

        $xmlElement = $this->streamXML->parseXML($this->xml);
        $result     = (array)$xmlElement->bar;

        $this->assertInstanceOf(\SimpleXMLElement::class, $xmlElement);
        $this->assertEquals($string, $result[0]);
    }
}
