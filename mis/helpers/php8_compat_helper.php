<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/*
 * PHP 8 compatibility helpers
 * ---------------------------------------------------------------------------
 * PHP 8 throws a TypeError in a few places where PHP 7.2 only raised a warning
 * and carried on. Each helper below returns exactly what PHP 7.2 returned, so
 * existing application logic is unchanged:
 *
 *   - For normal input (real arrays, numeric strings) the result is identical
 *     to the built-in function.
 *   - For the inputs that now throw (null/false/strings passed as arrays,
 *     non-numeric strings used in arithmetic) the PHP 7.2 result is returned.
 *
 * Loaded through $autoload['helper'] in config/autoload.php.
 */

/**
 * count()/sizeof() as in PHP 7.2: arrays and Countable objects are counted
 * normally; null counts as 0; any other value (false, string, number,
 * non-Countable object) counts as 1.
 */
if (!function_exists('php72_count')) {

    function php72_count($value, $mode = COUNT_NORMAL) {
        if (is_array($value) || $value instanceof Countable) {
            return count($value, $mode);
        }
        return ($value === null) ? 0 : 1;
    }

}

/**
 * in_array() as in PHP 7.2: when the haystack is not an array, PHP 7.2
 * returned NULL (falsy) instead of throwing.
 */
if (!function_exists('php72_in_array')) {

    function php72_in_array($needle, $haystack, $strict = false) {
        if (!is_array($haystack)) {
            return null;
        }
        return in_array($needle, $haystack, $strict);
    }

}

/**
 * implode()/join() as in PHP 7.2:
 *   - implode($glue, $array) and implode($array) work as normal;
 *   - the legacy argument order implode($array, $glue) is still accepted;
 *   - otherwise PHP 7.2 returned NULL (prints as an empty string).
 */
if (!function_exists('php72_implode')) {

    function php72_implode($glue, $pieces = null) {
        if (func_num_args() < 2) {
            return is_array($glue) ? implode($glue) : null;
        }
        if (is_array($pieces)) {
            return implode($glue, $pieces);
        }
        if (is_array($glue)) {
            return implode((string) $pieces, $glue);
        }
        return null;
    }

}

/**
 * Internal function call as in PHP 7.2: if any argument at the given
 * positions is not an array, PHP 7.2 returned NULL (with a warning) instead
 * of throwing a TypeError. Otherwise the real function is called with the
 * exact same arguments.
 */
if (!function_exists('php72_array_call')) {

    function php72_array_call($function, array $args, array $arrayPositions) {
        foreach ($arrayPositions as $pos) {
            if (array_key_exists($pos, $args) && !is_array($args[$pos])) {
                return null;
            }
        }
        return call_user_func_array($function, $args);
    }

}

if (!function_exists('php72_array_search')) {

    function php72_array_search() {
        return php72_array_call('array_search', func_get_args(), array(1));
    }

}

/**
 * array_key_exists() as in PHP 7.2: objects were accepted (their public
 * properties were checked); other non-arrays returned NULL.
 */
if (!function_exists('php72_array_key_exists')) {

    function php72_array_key_exists($key, $array) {
        if (is_array($array)) {
            return array_key_exists($key, $array);
        }
        if (is_object($array)) {
            return array_key_exists($key, get_object_vars($array));
        }
        return null;
    }

}

if (!function_exists('php72_array_merge')) {

    function php72_array_merge() {
        $args = func_get_args();
        return php72_array_call('array_merge', $args, array_keys($args));
    }

}

if (!function_exists('php72_array_column')) {

    function php72_array_column() {
        return php72_array_call('array_column', func_get_args(), array(0));
    }

}

if (!function_exists('php72_array_keys')) {

    function php72_array_keys() {
        return php72_array_call('array_keys', func_get_args(), array(0));
    }

}

if (!function_exists('php72_array_values')) {

    function php72_array_values() {
        return php72_array_call('array_values', func_get_args(), array(0));
    }

}

if (!function_exists('php72_array_unique')) {

    function php72_array_unique() {
        return php72_array_call('array_unique', func_get_args(), array(0));
    }

}

if (!function_exists('php72_array_sum')) {

    function php72_array_sum() {
        return php72_array_call('array_sum', func_get_args(), array(0));
    }

}

if (!function_exists('php72_array_filter')) {

    function php72_array_filter() {
        return php72_array_call('array_filter', func_get_args(), array(0));
    }

}

if (!function_exists('php72_array_slice')) {

    function php72_array_slice() {
        return php72_array_call('array_slice', func_get_args(), array(0));
    }

}

if (!function_exists('php72_array_diff')) {

    function php72_array_diff() {
        $args = func_get_args();
        return php72_array_call('array_diff', $args, array_keys($args));
    }

}

if (!function_exists('php72_array_intersect')) {

    function php72_array_intersect() {
        $args = func_get_args();
        return php72_array_call('array_intersect', $args, array_keys($args));
    }

}

if (!function_exists('php72_array_flip')) {

    function php72_array_flip() {
        return php72_array_call('array_flip', func_get_args(), array(0));
    }

}

if (!function_exists('php72_array_reverse')) {

    function php72_array_reverse() {
        return php72_array_call('array_reverse', func_get_args(), array(0));
    }

}

/**
 * array_combine() as in PHP 7.2: non-arrays returned NULL, and arrays of
 * different sizes returned FALSE (PHP 8 throws a ValueError instead).
 */
if (!function_exists('php72_array_combine')) {

    function php72_array_combine($keys, $values) {
        if (!is_array($keys) || !is_array($values)) {
            return null;
        }
        if (count($keys) !== count($values)) {
            return false;
        }
        return array_combine($keys, $values);
    }

}

/**
 * array_map() as in PHP 7.2: if any array argument is not an array, PHP 7.2
 * returned NULL.
 */
if (!function_exists('php72_array_map')) {

    function php72_array_map() {
        $args = func_get_args();
        return php72_array_call('array_map', $args, array_slice(array_keys($args), 1));
    }

}

/**
 * Operand for arithmetic as in PHP 7.2: a string with no leading number
 * ("", "abc") was treated as 0. Numeric and leading-numeric strings
 * ("12", "2.5", "12abc") are returned unchanged, so PHP evaluates them
 * exactly as before. Non-string values are returned unchanged.
 */
if (!function_exists('php72_num')) {

    function php72_num($value) {
        if (is_string($value) && !is_numeric($value) && !preg_match('/^\s*[+-]?(\d|\.\d)/', $value)) {
            return 0;
        }
        return $value;
    }

}

/**
 * money_format() was removed in PHP 8.0. This replacement implements the
 * strfmon() format specification using the current LC_MONETARY locale data
 * from localeconv(), including the locale's digit grouping (for example the
 * Indian 3;2 grouping: 1,00,000). It is only defined when PHP does not
 * provide money_format() itself.
 */
if (!function_exists('php72_strfmon')) {

    function php72_strfmon($format, $number, array $locale) {
        $regex = '/%((?:[\^!\-]|\+|\(|\=.)*)([0-9]+)?(?:#([0-9]+))?(?:\.([0-9]+))?([in%])/';
        preg_match_all($regex, $format, $matches, PREG_SET_ORDER);
        foreach ($matches as $fmatch) {
            if ($fmatch[5] == '%') {
                $format = str_replace($fmatch[0], '%', $format);
                continue;
            }
            $value = floatval($number);
            $flags = array(
                'fillchar' => preg_match('/\=(.)/', $fmatch[1], $match) ? $match[1] : ' ',
                'nogroup' => preg_match('/\^/', $fmatch[1]) > 0,
                'usesignal' => preg_match('/\+|\(/', $fmatch[1], $match) ? $match[0] : '+',
                'nosimbol' => preg_match('/\!/', $fmatch[1]) > 0,
                'isleft' => preg_match('/\-/', $fmatch[1]) > 0
            );
            $width = isset($fmatch[2]) && trim($fmatch[2]) !== '' ? (int) $fmatch[2] : 0;
            $left = isset($fmatch[3]) && trim($fmatch[3]) !== '' ? (int) $fmatch[3] : 0;
            $conversion = $fmatch[5];
            if (isset($fmatch[4]) && trim($fmatch[4]) !== '') {
                $right = (int) $fmatch[4];
            } else {
                $right = ($conversion == 'i') ? $locale['int_frac_digits'] : $locale['frac_digits'];
                if ($right < 0 || $right > 20) {
                    $right = 2;
                }
            }

            $positive = true;
            if ($value < 0) {
                $positive = false;
                $value *= -1;
            }
            $letter = $positive ? 'p' : 'n';
            $prefix = $suffix = $cprefix = $csuffix = '';
            $signal = $positive ? $locale['positive_sign'] : $locale['negative_sign'];
            $signPosn = $locale["{$letter}_sign_posn"];
            if ($flags['usesignal'] == '(' || $signPosn == 0) {
                $prefix = '(';
                $suffix = ')';
            } else if ($signPosn == 1 || $signPosn == 127) {
                $prefix = $signal;
            } else if ($signPosn == 2) {
                $suffix = $signal;
            } else if ($signPosn == 3) {
                $cprefix = $signal;
            } else if ($signPosn == 4) {
                $csuffix = $signal;
            }

            $currency = '';
            if (!$flags['nosimbol']) {
                $currency = $cprefix . ($conversion == 'i' ? $locale['int_curr_symbol'] : $locale['currency_symbol']) . $csuffix;
            }
            $space = ($locale["{$letter}_sep_by_space"] && $locale["{$letter}_sep_by_space"] != 127) ? ' ' : '';

            // Digits, then the locale's grouping (mon_grouping), then the decimal part
            $digits = number_format($value, $right, '.', '');
            $parts = explode('.', $digits);
            $int = $parts[0];
            $sep = $flags['nogroup'] ? '' : $locale['mon_thousands_sep'];
            $grouping = isset($locale['mon_grouping']) ? $locale['mon_grouping'] : array();
            if ($sep !== '' && !empty($grouping)) {
                $groups = array();
                $i = strlen($int);
                $g = 0;
                $size = (int) $grouping[0];
                while ($i > 0) {
                    if ($size <= 0 || $size >= 127) {
                        $groups[] = substr($int, 0, $i);
                        break;
                    }
                    $start = max(0, $i - $size);
                    $groups[] = substr($int, $start, $i - $start);
                    $i = $start;
                    if (isset($grouping[$g + 1])) {
                        $g++;
                        $size = (int) $grouping[$g];
                    }
                }
                $int = implode($sep, array_reverse($groups));
            }
            $n = strlen($prefix) + strlen($currency) + strlen($int);
            if ($left > 0 && $left > $n) {
                $int = str_repeat($flags['fillchar'], $left - $n) . $int;
            }
            $value = $int;
            if ($right > 0 && isset($parts[1])) {
                $value .= $locale['mon_decimal_point'] . $parts[1];
            }

            if ($locale["{$letter}_cs_precedes"]) {
                $value = $prefix . $currency . $space . $value . $suffix;
            } else {
                $value = $prefix . $value . $space . $currency . $suffix;
            }
            if ($width > 0) {
                $value = str_pad($value, $width, $flags['fillchar'], $flags['isleft'] ? STR_PAD_RIGHT : STR_PAD_LEFT);
            }
            $format = str_replace($fmatch[0], $value, $format);
        }
        return $format;
    }

}

if (!function_exists('money_format')) {

    function money_format($format, $number) {
        return php72_strfmon($format, $number, localeconv());
    }

}

/* End of file php8_compat_helper.php */
/* Location: ./mis/helpers/php8_compat_helper.php */
