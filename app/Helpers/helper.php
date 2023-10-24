<?php

function randomNumber($count = 5): string
{
    return substr(rand(0, microtime(true)), 0, $count);
}

function setAttachments(array $filespath, array $name = [], array $mime = []): array
{
    $result = [];
    foreach ($filespath as $key => $path) {

        array_push($result, [
            'path' => $path,
            'name' => $name[$key] ?? null,
            'mime' => $mime[$key] ?? null
        ]);
    }
    return $result;
}

function convertNumbersToEnglish($string)
{
    $newNumbers = range(0, 9);
    // 1. Persian HTML decimal
    $persianDecimal = array('&#1776;', '&#1777;', '&#1778;', '&#1779;', '&#1780;', '&#1781;', '&#1782;', '&#1783;', '&#1784;', '&#1785;');
    // 2. Arabic HTML decimal
    $arabicDecimal = array('&#1632;', '&#1633;', '&#1634;', '&#1635;', '&#1636;', '&#1637;', '&#1638;', '&#1639;', '&#1640;', '&#1641;');
    // 3. Arabic Numeric
    $arabic = array('٠', '١', '٢', '٣', '٤', '٥', '٦', '٧', '٨', '٩');
    // 4. Persian Numeric
    $persian = array('۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹');

    $string = str_replace($persianDecimal, $newNumbers, $string);
    $string = str_replace($arabicDecimal, $newNumbers, $string);
    $string = str_replace($arabic, $newNumbers, $string);
    return str_replace($persian, $newNumbers, $string);
}

function convertEnglishToPersian($number): array|string
{
    $number = str_replace('0', '۰', $number);
    $number = str_replace('1', '۱', $number);
    $number = str_replace('2', '۲', $number);
    $number = str_replace('3', '۳', $number);
    $number = str_replace('4', '۴', $number);
    $number = str_replace('5', '۵', $number);
    $number = str_replace('6', '۶', $number);
    $number = str_replace('7', '۷', $number);
    $number = str_replace('8', '۸', $number);
    $number = str_replace('9', '۹', $number);

    return $number;
}

function validateNationalCode($nationalCode): bool
{
    $nationalCode = trim($nationalCode, ' .');
    $nationalCode = convertNumbersToEnglish($nationalCode);
//    $nationalCode = convertArabicToEnglish($nationalCode);
//    $nationalCode = convertPersianToEnglish($nationalCode);
    $bannedArray = ['0000000000', '1111111111', '2222222222', '3333333333', '4444444444', '5555555555', '6666666666', '7777777777', '8888888888', '9999999999'];

    if (empty($nationalCode)) {
        return false;
    } else if (count(str_split($nationalCode)) != 10) {
        return false;
    } else if (in_array($nationalCode, $bannedArray)) {
        return false;
    } else {

        $sum = 0;

        for ($i = 0; $i < 9; $i++) {
            $sum += (int)$nationalCode[$i] * (10 - $i);
        }

        $divideRemaining = $sum % 11;

        if ($divideRemaining < 2) {
            $lastDigit = $divideRemaining;
        } else {
            $lastDigit = 11 - ($divideRemaining);
        }

        if ((int)$nationalCode[9] == $lastDigit) {
            return true;
        } else {
            return false;
        }

    }




//    function pdoErrorMessage(int $code): string{
//        $codeMessages = [
//            1146 => 'Table x does not exist',
//            1040 => 'Too many connections',
//            1045 => 'Access denied',
//            1064 => 'Syntax error',
//            1114 => 'Table is full',
//            2006 => 'MySQL server connection closed',
//            2008 => 'Client ran out of memory',
//            2013 => 'Lost connection during query',
//
//        ];
//        return $codeMessages[$code];
//    }
}
