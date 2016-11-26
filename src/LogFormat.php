<?php

namespace wappr;

/**
 * Class LogFormat.
 */
class LogFormat
{
    /**
     * Create the log format that will be used when writing to the file. It is
     * a template for the data: date/time, message, and an array.
     *
     * @param $level    string PSR-3 log levels
     * @param $message  string The log message to be written
     * @param $context  array  An option array to be written to the log file
     *
     * @return string Return the string with the formatted log message
     */
    public static function create($level, $message, array $context = [])
    {
        // Get milliseconds
        $ms = explode('.', microtime(true))[1];

        // Assemble the message. Ex. [debug] [2016-11-25 15:37:36.9468] hello
        $message = '['.$level.'] ['.date('Y-m-d G:i:s').'.'.$ms.'] '.$message;

        // If an array was passed as well, export it to a string
        if (count($context) > 0) {
            $message .= "\n".print_r($context, true);
        }

        return self::interpolate($message);
    }

    /**
     * Interpolate a string that contains braces as placeholders. It uses an associative
     * array as the key => value to replace the key (placeholder) with the value from the
     * array.
     *
     * @param $message  string The message containing the string that needs filtered
     * @param $context  array  An associative array of the key => value to interpolate
     *
     * @return string The message after it has been interpolated
     */
    protected static function interpolate($message, array $context = array())
    {
        // build a replacement array with braces around the context keys
        $replace = array();
        foreach ($context as $key => $val) {
            // check that the value can be casted to string
            if (!is_array($val) && (!is_object($val) || method_exists($val, '__toString'))) {
                $replace['{'.$key.'}'] = $val;
            }
        }

        // interpolate replacement values into the message and return
        return strtr($message, $replace);
    }
}
