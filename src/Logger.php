<?php

namespace wappr;

use League\Flysystem\FilesystemInterface;
use Psr\Log\AbstractLogger;
use Psr\Log\LogLevel;

/**
 * Class Logger.
 *
 * @author Levi Durfee <levi.durfee@gmail.com>
 *
 * @version 0.1.0
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
        'emergency' => 7,
        'alert' => 6,
        'critical' => 5,
        'error' => 4,
        'warning' => 3,
        'notice' => 2,
        'info' => 1,
        'debug' => 0,
    ];

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
            // Create a new LogFormat instance to format the log entry.
            $logFormat = new LogFormat($level, $message, $context);

            // Write the log message from the Log Format instance to the Log Format file name instance.
            $this->filesystem->put($logFormat->filename(), $logFormat->message()."\n");
        }
    }
}
