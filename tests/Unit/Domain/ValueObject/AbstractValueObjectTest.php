<?php

namespace Domain\ValueObject;

use Core\Domain\ValueObject\AbstractValueObject;
use PHPUnit\Framework\TestCase;

class AbstractValueObjectTest extends TestCase
{
    public function testEqualsReturnsTrueForSameAttributes()
    {
        $obj1 = new TestValueObject('value');
        $obj2 = new TestValueObject('value');

        $this->assertTrue($obj1->equals($obj2));
    }

    public function testEqualsReturnsFalseForDifferentAttributes()
    {
        $obj1 = new TestValueObject('value1');
        $obj2 = new TestValueObject('value2');

        $this->assertFalse($obj1->equals($obj2));
    }

    public function testEqualsReturnsFalseForDifferentClasses()
    {
        $obj1 = new TestValueObject('value');
        $obj2 = new AnotherTestValueObject('value');

        $this->assertFalse($obj1->equals($obj2), 'Objects of different classes should not be considered equal.');
    }
}


class TestValueObject extends AbstractValueObject
{
    private $attribute;

    public function __construct($attribute)
    {
        $this->attribute = $attribute;
    }

    public function getAttributes(): array
    {
        return ['attribute' => $this->attribute];
    }
}

class AnotherTestValueObject extends AbstractValueObject
{
    private $attribute;

    public function __construct($attribute)
    {
        $this->attribute = $attribute;
    }

    public function getAttributes(): array
    {
        return ['attribute' => $this->attribute];
    }
}

