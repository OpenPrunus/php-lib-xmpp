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

        $this->emptyElementXml = "<?xml version='1.0'?>
<stream:stream
    xmlns:stream='http://etherx.jabber.org/streams'
    version='1.0'
    from='toto.to'
    id='xxxxxxxxxxxxxxxxxxxx'
    xml:lang='en'
    xmlns='jabber:client'>
</stream:stream>";

        $this->streamXML = new StreamXML($this->streamXMLClient);
    }

    /**
     * Test if Parse XML successed
     */
    public function testParseXMLSuccess()
    {
        $string = 'TEST';
        $this->xml = sprintf($this->xml, $string);

        $this->streamXMLClient->method('parseXML')
                               ->willReturn(new \SimpleXMLElement($this->xml));

        $xmlElement = $this->streamXML->parseXML($this->xml);
        $result     = (array)$xmlElement->bar;

        $this->assertInstanceOf(\SimpleXMLElement::class, $xmlElement);
        $this->assertEquals($string, $result[0]);
    }

    /**
     * Test if Parse XML failed
     *
     * @expectedException XMPP\Exceptions\StreamXMLException
     */
    public function testParseXMLFailed()
    {
        $string = 'TEST';
        $xml = "truc";
        $this->xml = sprintf($xml, $string);

        $this->streamXMLClient->method('parseXML')
                              ->will($this->throwException(new \Exception));

        $xmlElement = $this->streamXML->parseXML($this->xml);
    }

    /**
     * Test if TLS is required
     */
    public function testIsTLSRequiredSuccess()
    {
        $xml = "<?xml version='1.0'?>
<stream:stream
    xmlns:stream='http://etherx.jabber.org/streams'
    version='1.0'
    from='toto.to'
    id='xxxxxxxxxxxxxxxxxxxx'
    xml:lang='en'
    xmlns='jabber:client'>
    <stream:features>
        <starttls xmlns='urn:ietf:params:xml:ns:xmpp-tls'>
            <required/>
        </starttls>
    </stream:features>
</stream:stream>";

        $this->streamXMLClient->method('parseXML')
                              ->willReturn(new \SimpleXMLElement($xml));

        $this->streamXML->parseXML($this->xml);

        $this->assertTrue($this->streamXML->isTLSRequired());

    }

    /**
     * Test if TLS is required failed
     */
    public function testIsTLSNotRequired()
    {
        $this->streamXMLClient->method('parseXML')
                              ->willReturn(new \SimpleXMLElement($this->emptyElementXml));

        $this->streamXML->parseXML($this->emptyElementXml);

        $this->assertFalse($this->streamXML->isTLSRequired());
    }

    /**
     * Test if TLS is required failed
     *
     * @expectedException XMPP\Exceptions\StreamXMLException
     */
    public function testIsTLSRequiredThrownStreamXMLException()
    {
        $this->streamXML->isTLSRequired();
    }

    /**
     * Test if no parsed file when we get mechanisms
     *
     * @expectedException XMPP\Exceptions\StreamXMLException
     */
    public function testMechanismsThrownStreamXMLException()
    {
        $this->streamXML->getMechanisms();
    }

    /**
     * Test if no mechanisms element found
     *
     * @expectedException XMPP\Exceptions\ElementsException
     */
    public function testMechanismsThrownElementsException()
    {
        $this->streamXMLClient->method('parseXML')
                              ->willReturn(new \SimpleXMLElement($this->emptyElementXml));

        $this->streamXML->parseXML($this->emptyElementXml);

        $this->streamXML->getMechanisms();
    }
}
