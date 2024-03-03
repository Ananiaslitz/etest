<?php

namespace Domain\Entity;

use Core\Domain\Entity\AbstractEntity;
use Core\Domain\ValueObject\IntegerIdValueObject;
use Tests\TestCase;

class AbstractEntityTest extends TestCase
{
    private $entity;

    protected function setUp(): void
    {
        parent::setUp();

        $this->id1 = new IntegerIdValueObject(1);
        $this->id2 = new IntegerIdValueObject(2);

        $this->entity1 = new class($this->id1) extends AbstractEntity {};
        $this->entity2 = new class($this->id1) extends AbstractEntity {};
        $this->entity3 = new class($this->id2) extends AbstractEntity {};
    }

    public function testEntityEquals()
    {
        $this->assertTrue(
            $this->entity1->equals($this->entity2),
            'As entidades com o mesmo ID devem ser consideradas iguais'
        );

        $this->assertFalse(
            $this->entity1->equals($this->entity3),
            'As entidades com IDs diferentes não devem ser consideradas iguais'
        );
    }

    public function testSetIdUpdatesEntityId()
    {
        $newId = new IntegerIdValueObject(3);

        $this->entity1->setId($newId);

        $this->assertTrue(
            $this->entity1->getId()->equals($newId),
            'O método setId deve atualizar o ID da entidade'
        );
    }

}
