<?php
namespace Tests\Calculator;

use FiscalCode\Calculator;
use PHPUnit\Framework\TestCase;

/**
 * Class TestCommons
 *
 * @author Michael Zangirolami <michael.zangirolami@triboo.it>
 * @author Lorenzo Calamandrei <lorenzo.calamandrei@triboo.it>
 * @version 0.1.0
 * @package Tests\Calculator
 */
final class TestCommons extends TestCase
{
    /**
     * testOneCommon
     *
     * @covers Calculator::getCommon()
     */
    public function testOneCommon()
    {
        $calc = new Calculator();
        $this->assertEquals('D612', $calc->getCommon("Firenze"));
    }

    /**
 * testWrongCommon
 *
 * @covers Calculator::getCommon()
 */
    public function testWrongCommon()
    {
        $calc = new Calculator();
        $this->assertNotEquals('MI', $calc->getCommon("Milano"));
    }
}

