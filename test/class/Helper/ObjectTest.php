<?php

class MyClass
{
    var $prop1;
    var $prop2;
    var $prop3;
    private $privProp;

    public function setPrivProp($s)
    {
        $this->privProp = $s;
    }
}

/**
 * @group Helper
 */
class ObjectTest extends \PHPUnit_Framework_TestCase
{

    function testBasic()
    {
        $o = new MyClass();
        $o->prop1 = "hej";
        $o->prop2 = ''; // verify empty props are not shown
        $o->prop3 = "hallå";
        $o->setPrivProp("bah"); // verify private props are not shown
        $this->assertEquals(
            "prop1: hej\n".
            "prop3: hallå",
            \Core3\Helper\Object::describePropertiesWithValues($o)
        );
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    function testBadInput()
    {
        \Core3\Helper\Object::describePropertiesWithValues("hej");
    }
}
