<?php

namespace wappr;

use wappr\Contracts\LogFilenameInterface;

/**
 * Class LogFilename.
 */
class LogFilename implements LogFilenameInterface
{
    /**
     * Create the log filename.
     *
     * @param $filenameFormat       string Accepts the same parameters as PHP's date function
     * @param $filenameExtension    string Accepts a file extension such as log
     *
     * @return string The filename for the log file that will be written
     */
    public function create($filenameFormat, $filenameExtension)
    {
        return date($filenameFormat).'.'.$filenameExtension;
    }
}
