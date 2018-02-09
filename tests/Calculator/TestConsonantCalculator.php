<?php
namespace Tests\Calculator;

use FiscalCode\FiscalCalculator;
use PHPUnit\Framework\TestCase;

/**
 * Class TestConsonantCalculator
 *
 * @author Michael Zangirolami <michael.zangirolami@triboo.it>
 * @author Lorenzo Calamandrei <lorenzo.calamandrei@triboo.it>
 * @version 0.1.0
 * @package Tests\Calculator
 */
final class TestConsonantCalculator extends TestCase
{

    /**
     * testSurname
     *
     * Get consonant from a full consonant surname example.
     * @covers FiscalCalculator::getConsonant()
     */
    public function testSurname()
    {
        $calc = new FiscalCalculator();
        $this->assertEquals("SRN", $calc->getConsonant("Surname"));
    }

    /**
     * testSurnameShort
     *
     * Get consonant, vowel and "X" from a surname example.
     * @covers FiscalCalculator::getConsonant()
     */
    public function testSurnameShort()
    {
        $calc = new FiscalCalculator();
        $this->assertEquals("BAX", $calc->getConsonant("AB"));
    }

    /**
     * testName
     *
     * Get consonant from the name example.
     * @covers FiscalCalculator::getConsonant()
     */
    public function testName()
    {
        $calc = new FiscalCalculator();
        $this->assertEquals("MHL", $calc->getConsonant("Michael", true));
    }

    /**
     * testNameVowel
     *
     * Get consonant fiscal code style from a short name.
     * @covers FiscalCalculator::getConsonant()
     */
    public function testNameVowel()
    {
        $calc = new FiscalCalculator();
        $this->assertEquals("LAI", $calc->getConsonant("Alice", true));
    }

    /**
     * testDoubleName
     *
     * Get consonant fiscal code style from a name with second name.
     * @covers FiscalCalculator::getConsonant()
     */
    public function testDoubleName()
    {
        $calc = new FiscalCalculator();
        $this->assertEquals("GNG", $calc->getConsonant("Giulia Angela", true ));
    }
}

