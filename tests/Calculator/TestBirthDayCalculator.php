<?php
namespace Tests\Calculator;

use FiscalCode\Calculator;
use PHPUnit\Framework\TestCase;

/**
 * Class TestBirthDayCalculator
 *
 * @author Michael Zangirolami <michael.zangirolami@triboo.it>
 * @author Lorenzo Calamandrei <lorenzo.calamandrei@triboo.it>
 * @version 0.1.0
 * @package Tests\Calculator
 */
final class TestBirthDayCalculator extends TestCase
{

    /**
     * testBirthDayForMale
     *
     * Get code by birthday for a male.
     * @covers Calculator::getFromBirthDay()
     */
    public function testBirthDayForMale()
    {
        $calc = new Calculator();
        $this->assertEquals("01", $calc->getFromBirthDay(
            \DateTime::createFromFormat('d', 1), "M")
        );
    }

    /**
     * testBirthDayForFemale
     *
     * Get code by birthday for a female.
     * @covers Calculator::getFromBirthDay()
     */
    public function testBirthDayForFemale()
    {
        $calc = new Calculator();
        $this->assertEquals("59", $calc->getFromBirthDay(
            \DateTime::createFromFormat('d', 19), "F")
        );
    }
}

