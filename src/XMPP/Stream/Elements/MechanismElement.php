<?php

namespace XMPP\Stream\Elements;

/**
 * MechanismElement model class
 */
class MechanismElement implements ElementInterface
{
    /**
     * @var array
     */
    protected $mechanisms;

    /**
     * Constructor
     *
     * @param array  $mechanisms
     *
     * @return MechanismElement
     */
    public function __construct(Array $mechanisms = array())
    {
        $this->mechanisms = $mechanisms;
    }

    /**
     * Return mechanisms array
     *
     * @return array
     */
    public function getMechanisms()
    {
        return $this->mechanisms;
    }

    /**
     * Set mechanisms array
     *
     * @param array $mechanisms
     *
     * @return FeaturesElement
     */
    public function setMechanisms(Array $mechanisms)
    {
        $this->mechanisms = $mechanisms;

        return $this;
    }
}
