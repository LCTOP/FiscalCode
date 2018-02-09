<?php
namespace Tests\FiscalCalculator;

use FiscalCode\FiscalCalculator;
use PHPUnit\Framework\TestCase;

/**
 * Class TestBirthDayFiscalCalculator
 *
 * @author Michael Zangirolami <michael.zangirolami@triboo.it>
 * @author Lorenzo Calamandrei <lorenzo.calamandrei@triboo.it>
 * @version 0.1.0
 * @package Tests\FiscalCalculator
 */
final class TestBirthDayFiscalCalculator extends TestCase
{

    /**
     * testBirthDayForMale
     *
     * Get code by birthday for a male.
     * @covers FiscalCalculator::getFromBirthDay()
     */
    public function testBirthDayForMale()
    {
        $calc = new FiscalCalculator();
        $this->assertEquals("01", $calc->getFromBirthDay(
            \DateTime::createFromFormat('d', 1), "M")
        );
    }

    /**
     * testBirthDayForFemale
     *
     * Get code by birthday for a female.
     * @covers FiscalCalculator::getFromBirthDay()
     */
    public function testBirthDayForFemale()
    {
        $calc = new FiscalCalculator();
        $this->assertEquals("59", $calc->getFromBirthDay(
            \DateTime::createFromFormat('d', 19), "F")
        );
    }
}

