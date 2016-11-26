<?php

namespace wappr;

/**
 * Class LogFormat.
 */
class LogFormat
{
    /**
     * @param $level
     * @param $message
     * @param array $context
     *
     * @return string
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

        return $message;
    }
}
