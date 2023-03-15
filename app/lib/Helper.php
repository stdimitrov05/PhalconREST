<?php

namespace App\Lib;

class Helper
{
    /**
     * @param $time
     * @return string
     */
    public static function humanTiming($time)
    {
        $originalTime = $time;
        $time = time() - $time;

        if ($time < 5) {
            return 'Just now';
        }

        $tokens = [
            3600 => 'hour',
            60 => 'minute',
            1 => 'second'
        ];

        foreach ($tokens as $unit => $text) {
            if ($time < $unit) continue;
            $numberOfUnits = floor($time / $unit);

            if ($unit == 3600 && $numberOfUnits >= 24) {
                $format = date('Y') == date('Y', $originalTime) ? 'M d' : 'M d Y';
                return date($format, $originalTime);
            } else {
                return $numberOfUnits . ' ' . $text . (($numberOfUnits > 1) ? 's ago' : ' ago');
            }
        }

        return '';
    }

    /**
     * @param $time
     * @return string
     */
    public static function humanTimingLong($time)
    {
        $originalTime = $time;
        $time = time() - $time;

        if ($time < 5) {
            return 'Just now';
        }

        $tokens = [
            3600 => 'hour',
            60 => 'minute',
            1 => 'second'
        ];

        foreach ($tokens as $unit => $text) {
            if ($time < $unit) continue;
            $numberOfUnits = floor($time / $unit);

            if ($unit == 3600 && $numberOfUnits >= 24) {
                $format = date('Y') == date('Y', $originalTime) ? 'D, M d, g:i A' : 'D, M d Y, g:i A';
                return date($format, $originalTime);
            } else {
                return $numberOfUnits . ' ' . $text . (($numberOfUnits > 1) ? 's ago' : ' ago');
            }
        }

        return '';
    }

    /**
     * @param $timestamp
     * @return string
     */
    public static function formatDate($timestamp)
    {
        return empty($timestamp) ? null : date('M d Y', $timestamp);
    }

    /**
     * @param $timestamp
     * @return string
     */
    public static function formatDateLong($timestamp)
    {
        return date('Y-m-d H:iA', $timestamp);
    }

    /**
     * @param $timestamp
     * @return string
     */
    public static function formatHour($timestamp)
    {
        return date('H:iA', $timestamp);
    }

    public static function getTotalPages($pageLimit, $totalItems) {
        // If limit is set to 0 or set to number bigger then total items count
        // display all in one page
        if (($pageLimit < 1) || ($pageLimit > $totalItems)) {
            $totalPages = 1;
        } else {
            // Calculate rest numbers from dividing operation so we can add one
            // more page for this items
            $restItemsNum = $totalItems % $pageLimit;
            // if rest items > 0 then add one more page else just divide items by limit
            $totalPages = $restItemsNum > 0
                ? intval($totalItems / $pageLimit) + 1
                : intval($totalItems / $pageLimit);
        }

        return $totalPages;
    }

    public static function generateToken()
    {
        return bin2hex(random_bytes(16));
    }

    /**
     * Convert decimal styled money to integer (cents)
     * @param string $money
     * @return int
     */
    public static function moneyToInt($money)
    {
        return number_format(
            preg_replace("/[^0-9\.]/","", $money),
            2,
            '.',
            ''
        ) * 100;
    }

    /**
     * Convert seconds to time format (00:00:00)
     * @param int $seconds
     * @return string
     */
    public static function secondsToTime($seconds)
    {
        $H = floor($seconds / 3600);
        $i = ($seconds / 60) % 60;
        $s = $seconds % 60;

        if ($H > 0)
            return sprintf("%01d:%02d:%02d", $H, $i, $s);
        else
            return sprintf("%02d:%02d", $i, $s);
    }

    /**
     * Replace multiple whitespace with single space
     *
     * @param string $text
     * @return string
     */
    public static function singleSpace($text)
    {
        // Replace whitespace characters with a single space
        return preg_replace('/ +/', ' ', $text);
    }

    /**
     * Return the slug of a string to be used in a URL.
     *
     * @return String
     */
    public static function slugify($text){
        // replace non letter or digits by -
        $text = preg_replace('~[^\pL\d]+~u', '-', $text);

        // transliterate
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

        // remove unwanted characters
        $text = preg_replace('~[^-\w]+~', '', $text);

        // trim
        $text = trim($text, '-');

        // remove duplicated - symbols
        $text = preg_replace('~-+~', '-', $text);

        // lowercase
        $text = strtolower($text);

        if (empty($text)) {
            return 'n-a';
        }

        return $text;
    }

    public static function length($string = null, $encoding = 'UTF-8')
    {
        return mb_strlen(str_replace("\r\n", "\n", $string), $encoding);
    }

    public static function formatPrice($price)
    {
        return number_format($price, 2);
    }

}
