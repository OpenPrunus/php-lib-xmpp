<?php

namespace XMPP\Stream\XML;

use XMPP\Exceptions\ElementsException;
use XMPP\Exceptions\StreamXMLException;

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
        try {
            $this->simpleXMLElement = $this->streamXMLClient->parseXML($xml);
        } catch(\Exception $e) {
            throw new StreamXMLException($e->getMessage());
        }

        return $this->simpleXMLElement;
    }

    /**
     * Check if TLS required field is in XML DOM
     *
     * @return bool
     *
     * @throws StreamXMLException
     */
    public function isTLSRequired()
    {
        if ($this->simpleXMLElement === null) {
            throw new StreamXMLException("No parsed xml file");
        }

        return isset($this->simpleXMLElement->children('stream', true)->features) &&
               isset($this->simpleXMLElement->children('stream', true)->features->children()->starttls) &&
               isset($this->simpleXMLElement->children('stream', true)->features->children()->starttls->children()->required);
    }

    /**
     * Get mechanisms in XML DOM
     *
     * @return array
     *
     * @throws ElementsException|StreamXMLException
     */
    public function getMechanisms()
    {
        if ($this->simpleXMLElement === null) {
            throw new StreamXMLException("No parsed xml file");
        }

        if (isset($this->simpleXMLElement->children('stream', true)->features) &&
            isset($this->simpleXMLElement->children('stream', true)->features->children()->mechanisms) &&
            isset($this->simpleXMLElement->children('stream', true)->features->children()->mechanisms->mechanism)) {
            return (array)$this->simpleXMLElement->children('stream', true)->features->children()->mechanisms->mechanism;
        } else {
            throw new ElementsException("Mechanism element doesn't exist");
        }
    }
}
