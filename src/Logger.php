<?php

namespace wappr;

use League\Flysystem\FilesystemInterface;
use Psr\Log\AbstractLogger;
use Psr\Log\LogLevel;
use wappr\Contracts\LogFilenameInterface;
use wappr\Contracts\LogFormatInterface;

/**
 * Class Logger.
 *
 * @author Levi Durfee <levi.durfee@gmail.com>
 *
 * @version 1.2.0
 */
class Logger extends AbstractLogger
{
    /**
     * Flysystem filesystem abstraction.
     *
     * @var FilesystemInterface
     */
    private $filesystem;

    /**
     * Lowest level of logging to write.
     *
     * @var LogLevel
     */
    private $threshold;

    /**
     * Associative array of the log levels that are given a numerical value
     * to allow comparison of the threshold and the method calling log.
     *
     * @var array
     */
    private $levels = [
        LogLevel::EMERGENCY => 7,
        LogLevel::ALERT => 6,
        LogLevel::CRITICAL => 5,
        LogLevel::ERROR => 4,
        LogLevel::WARNING => 3,
        LogLevel::NOTICE => 2,
        LogLevel::INFO => 1,
        LogLevel::DEBUG => 0,
    ];

    /**
     * Date format of the log filename.
     *
     * @var string
     */
    private $filenameFormat = 'Y-m-d';

    /**
     * Extension of the log file.
     *
     * @var string
     */
    private $filenameExtension = 'log';

    /**
     * @var LogFormatInterface
     */
    private $logFormat;

    /**
     * @var LogFilenameInterface
     */
    private $logFilename;

    /**
     * Logger constructor.
     *
     * @param FilesystemInterface $filesystem Flysystem filesystem abstraction
     * @param string              $threshold  Lowest level of logging to write
     */
    public function __construct(FilesystemInterface $filesystem, $threshold)
    {
        $this->filesystem = $filesystem;
        $this->threshold = $threshold;
        $this->logFormat = new LogFormat;
        $this->logFilename = new LogFilename;
    }

    /**
     * Logs with an arbitrary level.
     *
     * @param mixed  $level
     * @param string $message
     * @param array  $context
     *
     * @return bool
     */
    public function log($level, $message, array $context = [])
    {
        // If the level is greater than or equal to the threshold, then we should log it.
        if ($this->levels[$level] >= $this->levels[$this->threshold]) {
            // Call the LogFilename static function create to get the filename.
            $filename = $this->logFilename->create($this->filenameFormat, $this->filenameExtension);

            // Create a new LogFormat instance to format the log entry.
            $message = $this->logFormat->create($level, $message, $context);

            $contents = '';

            // Check and see if the file exists.
            if ($this->filesystem->has($filename)) {
                // Get the contents of the file before writing to it. This is so it can be appended.
                $contents = $this->filesystem->read($filename);
            }

            $contents .= $message;

            // Write the log message from the Log Format instance to the Log Format file name instance.
            $this->filesystem->put($filename, $contents."\n");
        }
    }

    /**
     * Set the log filename format using PHP's date parameters.
     *
     * @link https://secure.php.net/manual/en/function.date.php
     *
     * @param string $filenameFormat
     *
     * @deprecated 1.2.0 This method is no longer used since there is now a LogFilenameInterface
     */
    public function setFilenameFormat($filenameFormat)
    {
        $this->filenameFormat = $filenameFormat;
    }

    /**
     * Set the filename extension. Ex: 'log' will be '.log'.
     *
     * @param string $filenameExtension
     *
     * @deprecated 1.2.0 This method is no longer used since there is now a LogFilenameInterface
     */
    public function setFilenameExtension($filenameExtension)
    {
        $this->filenameExtension = $filenameExtension;
    }

    /**
     * Optionally create your own LogFormat class and set it to be used instead.
     *
     * @param LogFormatInterface $logFormat
     */
    public function setLogFormat(LogFormatInterface $logFormat)
    {
        $this->logFormat = $logFormat;
    }

    /**
     * Optionally create your own LogFilename class and use this method to use it.
     *
     * @param LogFilenameInterface $logFilename
     */
    public function setLogFilename(LogFilenameInterface $logFilename)
    {
        $this->logFilename = $logFilename;
    }
}
