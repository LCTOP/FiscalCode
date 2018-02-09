<?php
namespace Tests\FiscalCalculator;

use FiscalCode\FiscalCalculator;
use PHPUnit\Framework\TestCase;

/**
 * Class TestFiscalCode
 *
 * @author Michael Zangirolami <michael.zangirolami@triboo.it>
 * @author Lorenzo Calamandrei <lorenzo.calamandrei@triboo.it>
 * @version 0.1.0
 * @package Tests\FiscalCalculator
 */
final class TestFiscalCode extends TestCase
{

    protected $users;

    public function setUp()
    {
        $this->users = array(
            array(
                "name" => "Elisa",
                "surname" => "Pollo",
                "sex" =>  "F",
                "birthday" => "1987-06-04",
                "common" => "Agrigento",
                "assert" => "PLLLSE87H44A089B",
            ),
            array(
                "name" => "Antonio",
                "surname" => "Sacchi",
                "sex" =>  "M",
                "birthday" => "1991-01-01",
                "common" => "Belluno",
                "assert" => "SCCNTN91A01A757R",
            ),
        );
    }

    /**
     * testFiscalCode
     *
     * @covers FiscalCalculator::calculate()
     */
    public function testFiscalCode()
    {
        if (is_array($this->users)) {
            foreach ($this->users as $user) {
                $this->assertEquals(
                    $user["assert"],
                    FiscalCalculator::calculate(
                        $user["name"],
                        $user["surname"],
                        new \DateTime($user["birthday"]),
                        $user["sex"],
                        $user["common"]
                    )
                );
            }
        }
    }
}

