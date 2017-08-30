<?php

namespace XMPP\Stream\XML;

interface StreamXMLInterface
{
    /**
     * Constructor
     *
     * @param StreamXMLClientInterface $StreamXMLClient
     *
     * @return StreamXMLInterface
     */
    public function __construct(StreamXMLClientInterface $streamXMLClient);

    /**
     * Parse a xml string
     *
     * @param string $xml
     *
     * @return \SimpleXMLElement
     */
    public function parseXML($xml);
}
