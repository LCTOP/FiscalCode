<?php
namespace Tests\Calculator;

use FiscalCode\Calculator;
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
     * @covers Calculator::getConsonant()
     */
    public function testSurname()
    {
        $calc = new Calculator();
        $this->assertEquals("SRN", $calc->getConsonant("Surname"));
    }

    /**
     * testSurnameShort
     *
     * Get consonant, vowel and "X" from a surname example.
     * @covers Calculator::getConsonant()
     */
    public function testSurnameShort()
    {
        $calc = new Calculator();
        $this->assertEquals("BAX", $calc->getConsonant("AB"));
    }

    /**
     * testName
     *
     * Get consonant from the name example.
     * @covers Calculator::getConsonant()
     */
    public function testName()
    {
        $calc = new Calculator();
        $this->assertEquals("MHL", $calc->getConsonant("Michael", true));
    }

    /**
     * testNameVowel
     *
     * Get consonant fiscal code style from a short name.
     * @covers Calculator::getConsonant()
     */
    public function testNameVowel()
    {
        $calc = new Calculator();
        $this->assertEquals("LAI", $calc->getConsonant("Alice", true));
    }

    /**
     * testDoubleName
     *
     * Get consonant fiscal code style from a name with second name.
     * @covers Calculator::getConsonant()
     */
    public function testDoubleName()
    {
        $calc = new Calculator();
        $this->assertEquals("GNG", $calc->getConsonant("Giulia Angela", true ));
    }
}

