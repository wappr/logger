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
     * @param $filenameFormat
     * @param $filenameExtension
     *
     * @return string
     */
    public static function create($filenameFormat, $filenameExtension)
    {
        return date($filenameFormat).'.'.$filenameExtension;
    }
}
