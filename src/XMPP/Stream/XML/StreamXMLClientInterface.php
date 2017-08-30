<?php

namespace XMPP\Stream\XML;

interface StreamXMLClientInterface
{
    /**
     * Parse a xml string
     *
     * @param string $xml
     *
     * @return \SimpleXMLElement
     */
    public function parseXML($xml);
}
