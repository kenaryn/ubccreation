<?php

namespace App\Tests;

use App\Entity\Yard;
use PHPUnit\Framework\TestCase;

class YardTest extends TestCase
{
    public function testSomething(): void
    {
        $this->assertTrue(true);
    }


    public function testSetCity(): void
    /**
     * Tests either city's getter.
     */
    {
        $yard = new Yard();
        $yard->setCity('Olivet');
        $this->assertEquals('Olivet', $yard->getCity());
    }
}
