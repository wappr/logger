<?php

namespace wappr;

/**
 * Class LogFilename.
 */
class LogFilename
{
    /**
     * Create the log filename.
     *
     * @param $filenameFormat       string Accepts the same parameters as PHP's date function
     * @param $filenameExtension    string Accepts a file extension such as log
     *
     * @return string The filename for the log file that will be written.
     */
    public static function create($filenameFormat, $filenameExtension)
    {
        return date($filenameFormat).'.'.$filenameExtension;
    }
}
