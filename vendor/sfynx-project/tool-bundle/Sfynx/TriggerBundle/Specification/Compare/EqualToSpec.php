<?php

namespace Sfynx\TriggerBundle\Specification\Compare;

use Sfynx\TriggerBundle\Specification\Builder\InterfaceSpecification;
use Sfynx\TriggerBundle\Specification\Compare\abstractSpecification;

/**
 * This file is part of the <Trigger> project.
 * true if $a > $b
 * 
 * @category   Trigger
 * @package    Specification
 * @subpackage Object
 * @author     Etienne de Longeaux <etienne.delongeaux@gmail.com>
 */
class EqualToSpec extends abstractSpecification implements InterfaceSpecification {

    private $specification1;
    private $specification2;

    function __construct($specification1, $specification2) {
        $this->specification1 = $specification1;
        $this->specification2 = $specification2;
    }

    public function isSatisfiedBy($object = null) {
        if ($this->specification1 instanceof  InterfaceSpecification
                && $this->specification2 instanceof  InterfaceSpecification)
        {
            return ($this->specification1->isSatisfiedBy($object)
                    == $this->specification2->isSatisfiedBy($object));
        } else {
            return $this->run();
        }
    }
    
    public function run() {
            return ($this->specification1 == $this->specification2);
    }    
}