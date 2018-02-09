<?php
namespace Tests\Calculator;

use FiscalCode\FiscalCalculator;
use PHPUnit\Framework\TestCase;

/**
 * Class TestCheckFiscalCode
 *
 * @author Michael Zangirolami <michael.zangirolami@triboo.it>
 * @author Lorenzo Calamandrei <lorenzo.calamandrei@triboo.it>
 * @version 0.1.0
 * @package Tests\Calculator
 */
final class TestCheckFiscalCode extends TestCase
{
    public function testCheckFiscalCode()
    {
        $calc = new FiscalCalculator();
        $this->assertEquals("R", $calc->checkFiscalCode("SCCNTN91A01A757"));
    }

    public function testCheckFiscalCode2()
    {
        $calc = new FiscalCalculator();
        $this->assertEquals("B", $calc->checkFiscalCode("PLLLSE87H44A089"));
    }
}

