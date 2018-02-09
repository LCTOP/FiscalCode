<?php
namespace FiscalCode\CheckerFiscalCode;
use FiscalCode\FiscalCalculator;

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
     * @param string|bool $name
     * @param string|bool $surname
     * @param string|bool $birthday
     * @param $sex
     * @param string|bool $common
     * @param string|bool $known_common
     * @return int
     */
    public static function verifyFiscalCode(
        $name = false,
        $surname = false,
        $birthday = false,
        $sex = false,
        $common = false,
        $known_common = false
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

        // control for birthday
        if ($birthday && $sex) {
            $certifiedFiscalCode['birthday'] = FiscalCalculator::getFromBirthDay(
                \DateTime::createFromFormat('Y-', $birthday),
                $sex
            );
        } elseif ($birthday && !$sex) {
            $certifiedFiscalCode['birthday-not-sure'] = FiscalCalculator::getFromBirthDay(
                \DateTime::createFromFormat('Y-', $birthday),
                false
            );
        }

        if ($common) {
            list($italian_commons, $foreign_commons) = FiscalCalculator::_construct();
            if ($known_common) {
                //$certifiedFiscalCode['common'] =
            } else {
                //$certifiedFiscalCode['common'] =
            }
        }

        return 0;
    }
}

