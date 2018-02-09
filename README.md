# Fiscal Code
###### v 1.0.0

This module calculate the fiscal code of a person by information.

# HOW USE IT

For use it you can instance it or call statically.
FiscalCalculator is the class for calc the fiscal code by data user.
CheckerFiscalCode is for verify the fiscal code assert by a user using user's data.

# Example

For calculate the fiscal code of a person:

```PHP
$fiscalCode = FiscalCalculator::calculate(
    $user["name"],
    $user["surname"],
    new \DateTime($user["birthday"]),
    $user["sex"],
    $user["common"],
    $user["country"]
);
```

For calculate single piece of fiscal code you can use "minor" methods like:

```
 - getConsonant [For get the consonant or vowel in a name or surname @see the signature]
 - getGlobalCommon [For get the common code of an user]
 - getFromBirthDay [For get the day of the birth correctly formatted]
 - checkLastLetterFiscalCode [For validate a fiscal code (without last char) - This calc last char]
 
 etc...
 
 @see class FiscalCalculator
```