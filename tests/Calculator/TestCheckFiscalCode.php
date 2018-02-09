<?php
namespace Tests\FiscalCalculator;

use FiscalCode\FiscalCalculator;
use PHPUnit\Framework\TestCase;

/**
 * Class TestCheckFiscalCode
 *
 * @author Michael Zangirolami <michael.zangirolami@triboo.it>
 * @author Lorenzo Calamandrei <lorenzo.calamandrei@triboo.it>
 * @version 0.1.0
 * @package Tests\FiscalCalculator
 */
final class TestCheckFiscalCode extends TestCase
{
    public function testCheckFiscalCode()
    {
        $calc = new FiscalCalculator();
        $this->assertEquals("R", $calc->checkLastLetterFiscalCode("SCCNTN91A01A757"));
    }

    public function testCheckFiscalCode2()
    {
        $calc = new FiscalCalculator();
        $this->assertEquals("B", $calc->checkLastLetterFiscalCode("PLLLSE87H44A089"));
    }
}

