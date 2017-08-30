<?php

namespace XMPP\Stream\XML;

/**
 * Class Client for XML steps
 *
 * @codeCoverageIgnore
 */
class StreamXMLClient implements StreamXMLClientInterface
{
    /**
     * @var \SimpleXMLElement
     */
    protected $xml;

    /**
     * Constructor
     *
     * @return StreamXMLClient
     */
    public function __construct()
    {
        $this->xml = null;
    }

    /**
     * Parse a xml string
     *
     * @param string $xml
     *
     * @return \SimpleXMLElement
     */
    public function parseXML($xml)
    {
        $this->xml = new \SimpleXMLElement($xml);

        return $this->xml;
    }
}
