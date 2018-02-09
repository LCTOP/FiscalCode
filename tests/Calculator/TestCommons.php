<?php
namespace Tests\FiscalCalculator;

use FiscalCode\FiscalCalculator;
use PHPUnit\Framework\TestCase;

/**
 * Class TestCommons
 *
 * @author Michael Zangirolami <michael.zangirolami@triboo.it>
 * @author Lorenzo Calamandrei <lorenzo.calamandrei@triboo.it>
 * @version 0.1.0
 * @package Tests\FiscalCalculator
 */
final class TestCommons extends TestCase
{
    /**
     * testOneCommon
     *
     * @covers FiscalCalculator::getCommon()
     */
    public function testOneCommon()
    {
        $calc = new FiscalCalculator();
        $this->assertEquals('D612', $calc->getCommon("Firenze"));
    }

    /**
 * testWrongCommon
 *
 * @covers FiscalCalculator::getCommon()
 */
    public function testWrongCommon()
    {
        $calc = new FiscalCalculator();
        $this->assertNotEquals('MI', $calc->getCommon("Milano"));
    }
}

