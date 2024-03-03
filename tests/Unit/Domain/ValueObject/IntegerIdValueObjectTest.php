<?php

namespace Domain\ValueObject;

use Core\Domain\ValueObject\IntegerIdValueObject;
use PHPUnit\Framework\TestCase;

class IntegerIdValueObjectTest extends TestCase
{
    public function testCanInitializeWithId()
    {
        $idValue = 10;
        $id = new IntegerIdValueObject($idValue);

        $this->assertEquals($idValue, $id->getId());
    }

    public function testEqualsReturnsTrueForSameId()
    {
        $idValue = 10;
        $id1 = new IntegerIdValueObject($idValue);
        $id2 = new IntegerIdValueObject($idValue);

        $this->assertTrue($id1->equals($id2));
    }

    public function testEqualsReturnsFalseForDifferentIds()
    {
        $id1 = new IntegerIdValueObject(10);
        $id2 = new IntegerIdValueObject(20);

        $this->assertFalse($id1->equals($id2));
    }

    public function testIsInitializedReturnsTrueWhenIdIsNotNull()
    {
        $id = new IntegerIdValueObject(10);

        $this->assertTrue($id->isInitialized());
    }

    public function testIsInitializedReturnsFalseWhenIdIsNull()
    {
        $id = new IntegerIdValueObject();

        $this->assertFalse($id->isInitialized());
    }

    public function testCanBeInstantiatedAndRetrieved()
    {
        $idValue = 10;
        $idObject = new IntegerIdValueObject($idValue);

        $this->assertEquals($idValue, $idObject->getId());
    }

    public function testEqualityBetweenTwoIdObjects()
    {
        $idValue1 = new IntegerIdValueObject(10);
        $idValue2 = new IntegerIdValueObject(10);
        $idValue3 = new IntegerIdValueObject(20);

        $this->assertTrue($idValue1->equals($idValue2));
        $this->assertFalse($idValue1->equals($idValue3));
    }

    public function testIsInitialized()
    {
        $initializedId = new IntegerIdValueObject(10);
        $uninitializedId = new IntegerIdValueObject();

        $this->assertTrue($initializedId->isInitialized());
        $this->assertFalse($uninitializedId->isInitialized());
    }

    public function testToStringReturnsStringValueOfId()
    {
        $idValue = new IntegerIdValueObject(10);
        $this->assertEquals('10', (string) $idValue);
    }

    public function testGetValueReturnsIdValue()
    {
        $idValue = 10;
        $idObject = new IntegerIdValueObject($idValue);

        $this->assertEquals($idValue, $idObject->getValue());
    }

    public function testGetAttributesReturnsArrayOfId()
    {
        $idValue = 10;
        $idObject = new IntegerIdValueObject($idValue);
        $expectedAttributes = ['value' => $idValue];

        $this->assertEquals($expectedAttributes, $idObject->getAttributes());
    }
}
