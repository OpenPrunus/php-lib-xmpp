<?php

namespace XMPP\Stream\XML;

use XMPP\Exceptions\ElementsException;

/**
 * Class Stream for manage XML flows
 */
class StreamXML implements StreamXMLInterface
{
    /**
     * @var StreamXMLClient
     */
    protected $streamXMLClient;

    /**
     * @var \SimpleXMLElement
     */
    protected $simpleXMLElement;

    /**
     * {@inheritdoc}
     */
    public function __construct(StreamXMLClientInterface $streamXMLClient)
    {
        $this->streamXMLClient  = $streamXMLClient;
        $this->simpleXMLElement = null;
    }

    /**
     * {@inheritdoc}
     */
    public function parseXML($xml)
    {
        $this->simpleXMLElement = $this->streamXMLClient->parseXML($xml);

        return $this->simpleXMLElement;
    }

    /**
     * Check if TLS required field is in XML DOM
     *
     * @return bool
     */
    public function isTLSRequired()
    {
        return isset($this->simpleXMLElement->children('stream', true)->features->children()->starttls->children()->required);
    }

    /**
     * Get mechanisms in XML DOM
     *
     * @return array
     *
     * @throws ElementsException
     */
    public function getMechanisms()
    {
        if (isset($this->simpleXMLElement->children('stream', true)->features->children()->mechanisms->mechanism)) {
            return (array)$this->simpleXMLElement->children('stream', true)->features->children()->mechanisms->mechanism;
        } else {
            throw new ElementsException("Mechanism element doesn't exist");
        }
    }
}
