<?php

namespace XMPP\Stream;

use XMPP\Stream\Elements\StreamElement;
use XMPP\Stream\Elements\MechanismsElement;
use XMPP\Stream\XML\StreamXML;

interface StreamInterface
{
    /**
     * Constructor
     *
     * @param StreamElement     $streamElement
     * @param MechanismsElement $mechanismsElement
     * @param StreamXML         $streamXML
     *
     * @return StreamInterface
     */
    public function __construct(StreamElement $streamElement, MechanismsElement $mechanismsElement, StreamXML $streamXML);
}
