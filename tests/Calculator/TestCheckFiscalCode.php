<?php
namespace Tests\Calculator;

use FiscalCode\Calculator;
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
        $calc = new Calculator();
        $this->assertEquals("R", $calc->checkFiscalCode("SCCNTN91A01A757"));
    }

    public function testCheckFiscalCode2()
    {
        $calc = new Calculator();
        $this->assertEquals("B", $calc->checkFiscalCode("PLLLSE87H44A089"));
    }
}

