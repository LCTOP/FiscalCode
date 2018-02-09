<?php
namespace FiscalCode;

/**
 * Class FiscalCalculator
 *
 * Class for calculate fiscal code by user data
 * @author Michael Zangirolami <michael.zangirolami@triboo.it>
 * @author Lorenzo Calamandrei <lorenzo.calamandrei@triboo.it>
 * @version 0.1.0
 * @package FiscalCode
 */
class FiscalCalculator
{
    const vowel = array("A", "E", "I", "O", "U"),
        months = array("A", "B", "C", "D", "E", "H", "L", "M", "P", "R", "S", "T"),
        checkOdd = array(
            "0" => "1", "9" => "21", "I" => "19",
            "R" => "8", "1" => "0", "A" => "1",
            "J" => "21", "S" => "12", "2" => "5",
            "B" => "0", "K" => "2", "T" => "14",
            "3" => "7", "C" => "5", "L" => "4",
            "U" => "16", "4" => "9", "D" => "7",
            "M" => "18", "V" => "10", "5" => "13",
            "E" => "9", "N" => "20", "W" => "22",
            "6" => "15", "F" => "13", "O" => "11",
            "X" => "25", "7" => "17", "G" => "15",
            "P" => "3", "Y" => "24", "8" => "19",
            "H" => "17", "Q" => "6", "Z" => "23"
        );

    private $commons;
    private $foreign;

    /**
     * __construct
     *
     * FiscalCalculator constructor.
     */
    public function __construct()
    {
        $this->commons = array();
        $this->foreign = array();
        $commonsFile = fopen(__DIR__ . "/lib/commons.csv","r");
        $foreignFile = fopen(__DIR__ . "/lib/foreign.csv", 'r');

        while (!feof($commonsFile)) {
            array_push($this->commons, fgetcsv($commonsFile));
        }

        while (!feof($foreignFile)) {
            array_push($this->foreign, fgetcsv($foreignFile));
        }

        fclose($commonsFile);
        fclose($foreignFile);
    }

    /**
     * _construct
     *
     * @return array list of all
     */
    public static function _construct()
    {
        $commons = array();
        $foreign = array();
        $commonsFile = fopen(__DIR__ . "/lib/commons.csv","r");
        $foreignFile = fopen(__DIR__ . "/lib/foreign.csv", 'r');

        while (!feof($commonsFile)) {
            array_push($commons, fgetcsv($commonsFile));
        }

        while (!feof($foreignFile)) {
            array_push($foreign, fgetcsv($foreignFile));
        }

        fclose($commonsFile);
        fclose($foreignFile);

        return array($commons, $foreign);
    }

    /**
     * calculate
     *
     * Calc the fiscal code by user data.
     * @param string     $name
     * @param string     $surname
     * @param \DateTime  $birthday
     * @param string     $sex
     * @param string     $common
     * @param array|bool $commons
     * @param string     $country
     * @throws \Exception
     * @return bool|string
     */
    public static function calculate($name, $surname, \DateTime $birthday, $sex, $common, $commons = false, $country)
    {
        // control of params
        if (!$name || !$surname || !$birthday || !$sex || !$common) {
            return false;
        }

        $fiscalCode = "";

        // get surname and name
        $fiscalCode .= self::getConsonant($surname);
        $fiscalCode .= self::getConsonant($name, true);

        // get last two numbers of the years of birthday
        $yearBirth = $birthday->format("Y");
        $fiscalCode .= $yearBirth[2] . $yearBirth[3];

        // get letter linked to the months
        $fiscalCode .= self::months[(int)$birthday->format('m') - 1];

        $fiscalCode .= self::getFromBirthDay($birthday, $sex);

        $italian_commons = array();
        $foreign_commons = array();

        if (!$commons) {
            list($italian_commons, $foreign_commons) = self::_construct();
        }

        $fiscalCode .= self::getGlobalCommon($common, $country, $italian_commons, $foreign_commons);

        $fiscalCode .= self::checkLastLetterFiscalCode($fiscalCode);

        return $fiscalCode;
    }

    /**
     * getConsonant
     *
     * Get consonant from word and return it in fiscal code style.
     * @param string    $item The word for get consonant.
     * @param bool      $isName If the word is the name, the second consonant must be skipped.
     * @return bool|string
     */
    public static function getConsonant($item, $isName = false)
    {
        // control for param
        if (!$item) {
            return false;
        }

        // remove spaces from name that have second name
        if ($isName) {
            $item = str_replace(" ", "", $item);
        }

        $consonant = array();

        // search for consonant
        foreach (str_split($item) as $letter) {
            if (!in_array(strtoupper($letter), self::vowel)) {
                array_push($consonant, $letter);
            }
        }

        // if is a name, delete second consonant
        if (count($consonant) > 3 && $isName) {
            unset($consonant[1]);
        }

        // trim if more then 3 chars
        if (count($consonant) > 3) {
            $consonant = array_slice($consonant, 0, 3);
        }

        // search for vowel for fill it
        if (count($consonant) < 3) {
            foreach (str_split($item) as $letter) {
                if (in_array(strtoupper($letter), self::vowel) && count($consonant) < 3) {
                    array_push($consonant, $letter);
                }
            }
        }

        // add "X" if return string < 3 char
        if (count($consonant) < 3) {
            $tmp = implode("", $consonant);
            $consonant = implode("", array_fill(0, (3 - count($consonant)), "X"));
            return $tmp . $consonant;
        }
        return strtoupper(implode("", $consonant));
    }

    /**
     * getGlobalCommon
     *
     * @param $common
     * @param $country
     * @param $italian_commons
     * @param $foreign_commons
     * @return bool|string
     * @throws \Exception
     */
    protected static function getGlobalCommon ($common, $country, $italian_commons, $foreign_commons)
    {

        // check if country is italy or abroad
        if ($country == "italy") {
            $country = self::getCommon($common, $italian_commons);
        } elseif ($country == "abroad") {
            $country = self::getCommon($common, $foreign_commons);
        } else {
            throw new \Exception("You come from moon or mars, or you just need to select valid option");
        }

        return $country;
    }

    /**
     * getFromBirthDay
     *
     * Get numbers by sex and birthday, for female + 40 to the return
     * @param \DateTime $birthday
     * @param string|bool    $sex
     * @return bool|int
     */
    public static function getFromBirthDay(\DateTime $birthday, $sex)
    {
        // param control
        if (!$birthday) {
            return false;
        }

        $day = $birthday->format('d');

        // if sex is false, is assumed that is not known
        if (!$sex) {
            return $day;
        }

        // add 0 if birthday is under 10
        if ($sex === "M") {
            return $day;
        }
        return (string) ((int) $day + 40);
    }

    /**
     * getCommon
     *
     * Get common code by common name.
     * @param string $common common of the user
     * @param array  $commons list of all commons
     * @return bool|string If mismatch commons return ????
     */
    public static function getCommon($common, $commons)
    {
        if (!$common) {
            return false;
        }

        $found = false;

        // sanitize the string of the common
        $common = str_replace(" ", "", ucwords($common));
        foreach ($commons as $lineCommon) {

            // sanitize the string of the common get by line in csv of commons
            $lineCommon[0] = str_replace(" ", "", ucwords($lineCommon[0]));
            if ($common == $lineCommon[0]) {
                $found = $lineCommon[2];
            }
        }

        // if not found return ???? because the common isn't found in list
        return !$found ? '????' : $found;
    }

    /**
     *
     * getForeign
     *
     * Get foreign code by foreign state name
     * @param string $foreign
     * @return string
     */
    protected function getForeign($foreign)
    {
        if (!$foreign) {
            return false;
        }

        $found = false;

        // sanitize the string of foreign
        $foreign =  str_replace(" ", "", ucwords($foreign));

        foreach ($this->foreign as $lineForeign) {

            //sanitize the string of the foreign get by line in csv of foreign
            $lineForeign[1] = str_replace(" ", "", ucwords($lineForeign[1]));
            if ($foreign == $lineForeign[1]) {
                $found = $lineForeign[0];
            }
        }

        //if not found return ???? because the foreign isn't found in the list
        return !$found ? '????' : $found;
    }

    /**
     * checkFiscalCode
     *
     * Calc the validation code of the fiscal code.
     * @param string            $fiscalCode
     * @return bool|int|string
     */
    public static function checkLastLetterFiscalCode($fiscalCode)
    {
        // control of param
        if (!$fiscalCode) {
            return false;
        }

        // check var for calc validation letter
        $check = 0;

        for ($i = 1; $i <= count(str_split($fiscalCode)); $i++) {
            if ($i % 2 == 0) {
                if (is_numeric($fiscalCode[$i-1])) {
                    $check += (int) $fiscalCode[$i-1];
                } else {

                    // -97 because letter "a" in ASCII have the value 97
                    $check += (int) (ord(strtolower($fiscalCode[$i-1])) - 97);
                }
            } else {
                $check += (int) self::checkOdd[$fiscalCode[$i-1]];
            }
        }

        // +65 for reach "A" value in ASCII
        return chr(($check % 26) + 65);
    }
}

