<?php

namespace Domain\ValueObject;

use Core\Domain\ValueObject\DateTimeValueObject;
use PHPUnit\Framework\TestCase;

class DateTimeValueObjectTest extends TestCase
{
    public function testConstructorSetsDateTimeImmutable()
    {
        $dateString = '2021-01-01 00:00:00';
        $dateObject = new DateTimeValueObject($dateString);

        $this->assertInstanceOf(\DateTimeImmutable::class, $dateObject->getValue());
        $this->assertEquals($dateString, $dateObject->getValue()->format('Y-m-d H:i:s'));
    }

    public function testIsBefore()
    {
        $date1 = new DateTimeValueObject('2021-01-01');
        $date2 = new DateTimeValueObject('2022-01-01');

        $this->assertTrue($date1->isBefore($date2));
        $this->assertFalse($date2->isBefore($date1));
    }

    public function testIsAfter()
    {
        $date1 = new DateTimeValueObject('2021-01-01');
        $date2 = new DateTimeValueObject('2020-01-01');

        $this->assertTrue($date1->isAfter($date2));
        $this->assertFalse($date2->isAfter($date1));
    }

    public function testToString()
    {
        $date = new DateTimeValueObject('2021-01-01 00:00:00');
        $this->assertEquals('2021-01-01T00:00:00+00:00', (string)$date);
    }

    public function testGetAttributes()
    {
        $date = new DateTimeValueObject('2021-01-01 00:00:00');
        $expectedAttributes = ['value' => '2021-01-01T00:00:00+00:00'];

        $this->assertEquals($expectedAttributes, $date->getAttributes());
    }
}
