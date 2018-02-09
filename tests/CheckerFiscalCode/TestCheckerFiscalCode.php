<?php
namespace Tests\CheckerFiscalCalculator;

use FiscalCode\CheckerFiscalCode;
use FiscalCode\FiscalCalculator;
use PHPUnit\Framework\TestCase;

/**
 * Class TestCheckerFiscalCode
 *
 * @author Michael Zangirolami <michael.zangirolami@triboo.it>
 * @author Lorenzo Calamandrei <lorenzo.calamandrei@triboo.it>
 * @version 0.1.0
 * @package Tests\CheckerFiscalCalculator
 */
final class TestCheckerFiscalCode extends TestCase
{
    /**
     * testChecker
     *
     * @covers CheckerFiscalCode::verifyFiscalCode()
     * @throws \Exception
     */
    public function testChecker()
    {
        $this->assertEquals(
            true,
            CheckerFiscalCode::verifyFiscalCode(
                'PLLLSE87H44A089B',
                'Elisa',
                'Pollo',
                '1987-06-04',
                'F',
                'Agrigento',
                FiscalCalculator::CUSTOMER_ITALIAN
            )
        );
    }
}

