<?php
namespace FiscalCode;

/**
 * Class CheckerFiscalCode
 *
 * Class for check a Fiscal Code by fiscal code and data user
 * @author Michael Zangirolami <michael.zangirolami@triboo.it>
 * @author Lorenzo Calamandrei <lorenzo.calamandrei@triboo.it>
 * @version 0.1.0
 * @package FiscalCode\CheckerFiscalCode
 */
class CheckerFiscalCode
{
    /**
     * verifyFiscalCode
     *
     * @param string $fiscalCodeAssert
     * @param string|bool $name
     * @param string|bool $surname
     * @param string|bool $birthday
     * @param $sex
     * @param string|bool $common
     * @param string|bool $country
     * @throws \Exception
     * @return array|bool Return true if completly correct fiscal code assert, else return an array with the element
     *                          that match correct asserts.
     */
    public static function verifyFiscalCode(
        $fiscalCodeAssert,
        $name = false,
        $surname = false,
        $birthday = false,
        $sex = false,
        $common = false,
        $country = false
    ) {
        $certifiedFiscalCode = array();

        // if name ok, calculate piece of fiscal code by name
        if ($name) {
            $certifiedFiscalCode['name'] = FiscalCalculator::getConsonant($name, true);
        }

        // control for surname
        if ($surname) {
            $certifiedFiscalCode['surname'] = FiscalCalculator::getConsonant($surname);
        }

        $date_time_birth = new \DateTime();
        if ($birthday) {
            $date_time_birth = $date_time_birth->createFromFormat('Y-m-d', $birthday);
            $certifiedFiscalCode['month'] = FiscalCalculator::months[(int) $date_time_birth->format('m') - 1];
            // get last two numbers of the years of birthday
            $yearBirth = $date_time_birth->format("Y");
            $certifiedFiscalCode['year'] = $yearBirth[2] . $yearBirth[3];
        }

        // control for birthday
        if ($birthday && $sex) {
            $certifiedFiscalCode['day'] = FiscalCalculator::getFromBirthDay(
                $date_time_birth,
                $sex
            );
        } elseif ($birthday && !$sex) {
            // TODO: implement
            $certifiedFiscalCode['day-not-sure'] = FiscalCalculator::getFromBirthDay(
                $date_time_birth,
                false
            );
        }

        // validate common
        if ($common) {
            list($italian_commons, $foreign_commons) = FiscalCalculator::_construct();
            $certifiedFiscalCode['common'] = FiscalCalculator::getGlobalCommon(
                $common,
                $country,
                $italian_commons,
                $foreign_commons
            );
        }

        // splice fiscalCodeAssert
        $assert = array();

        $assert['name'] = implode('', array_slice(str_split($fiscalCodeAssert), 3, 3));
        $assert['surname'] = implode('', array_slice(str_split($fiscalCodeAssert), 0, 3));
        $assert['year'] = implode('', array_slice(str_split($fiscalCodeAssert), 6, 2));
        $assert['month'] = implode('', array_slice(str_split($fiscalCodeAssert), 8, 1));
        $assert['day'] = implode('', array_slice(str_split($fiscalCodeAssert), 9, 2));
        $assert['common'] = implode('', array_slice(str_split($fiscalCodeAssert), 11, 4));

        $correct = array();
        $incorrect = array();
        foreach ($assert as $key => $value) {
            if ($value == $certifiedFiscalCode[$key]) {
                array_push($correct, $key);
            } else {
                array_push($incorrect, $key);
            }
        }

        $all_eq = false;
        if (count($correct) === 6) {
            $all_eq = true;
        }

        return $all_eq ? $all_eq : array($correct, $incorrect);
    }
}

