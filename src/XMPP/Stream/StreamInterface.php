<?php

namespace XMPP\Stream;

use XMPP\Stream\Elements\StreamElement;
use XMPP\Stream\Elements\MechanismElement;
use XMPP\Stream\XML\StreamXML;

interface StreamInterface
{
    /**
     * Constructor
     *
     * @param Connection    $connection
     * @param StreamElement $stream
     *
     * @return StreamInterface
     */
    public function __construct(StreamElement $streamElement, MechanismElement $mechanismElement, StreamXML $streamXML);
}
