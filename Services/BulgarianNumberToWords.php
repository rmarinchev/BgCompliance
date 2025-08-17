<?php

namespace Modules\BgCompliance\Services;

class BulgarianNumberToWords
{
    private static $ones = [
        '', 'един', 'два', 'три', 'четири', 'пет', 'шест', 'седем', 'осем', 'девет',
        'десет', 'единадесет', 'дванадесет', 'тринадесет', 'четиринадесет', 'петнадесет',
        'шестнадесет', 'седемнадесет', 'осемнадесет', 'деветнадесет'
    ];

    private static $onesFeminine = [
        '', 'една', 'две', 'три', 'четири', 'пет', 'шест', 'седем', 'осем', 'девет',
        'десет', 'единадесет', 'дванадесет', 'тринадесет', 'четиринадесет', 'петнадесет',
        'шестнадесет', 'седемнадесет', 'осемнадесет', 'деветнадесет'
    ];

    private static $tens = [
        '', '', 'двадесет', 'тридесет', 'четиридесет', 'петдесет', 
        'шестдесет', 'седемдесет', 'осемдесет', 'деветдесет'
    ];

    private static $hundreds = [
        '', 'сто', 'двеста', 'триста', 'четиристотин', 'петстотин',
        'шестстотин', 'седемстотин', 'осемстотин', 'деветстотин'
    ];

    public static function convert(int $number, bool $feminine = false): string
    {
        if ($number === 0) {
            return 'нула';
        }

        if ($number < 0) {
            return 'минус ' . self::convert(abs($number), $feminine);
        }

        $ones = $feminine ? self::$onesFeminine : self::$ones;

        if ($number < 20) {
            return $ones[$number];
        }

        if ($number < 100) {
            $ten = intval($number / 10);
            $one = $number % 10;
            return self::$tens[$ten] . ($one > 0 ? ' и ' . $ones[$one] : '');
        }

        if ($number < 1000) {
            $hundred = intval($number / 100);
            $remainder = $number % 100;
            return self::$hundreds[$hundred] . ($remainder > 0 ? ' ' . self::convert($remainder, $feminine) : '');
        }

        if ($number < 1000000) {
            $thousand = intval($number / 1000);
            $remainder = $number % 1000;
            
            $thousandText = '';
            if ($thousand === 1) {
                $thousandText = 'хиляда';
            } elseif ($thousand < 1000) {
                $thousandText = self::convert($thousand, true) . ' хиляди';
            }
            
            return $thousandText . ($remainder > 0 ? ' ' . self::convert($remainder, $feminine) : '');
        }

        if ($number < 1000000000) {
            $million = intval($number / 1000000);
            $remainder = $number % 1000000;
            
            $millionText = '';
            if ($million === 1) {
                $millionText = 'един милион';
            } else {
                $millionText = self::convert($million) . ' милиона';
            }
            
            return $millionText . ($remainder > 0 ? ' ' . self::convert($remainder, $feminine) : '');
        }

        return (string) $number; // Fallback for very large numbers
    }
}