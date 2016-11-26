<?php

use League\Flysystem\Adapter\Local;
use League\Flysystem\Filesystem;
use wappr\LogFilename;
use wappr\LogFormat;
use wappr\Logger;

class otherLogClassesTest extends PHPUnit_Framework_TestCase
{
    public function testSpeicifyingLogClasses()
    {
        $adapter = new Local(dirname(__DIR__).'/storage/logs/');
        $filesystem = new Filesystem($adapter);
        $logger = new Logger($filesystem, Psr\Log\LogLevel::INFO);

        $logFilename = new LogFilename;
        $logFormat = new LogFormat;

        $this->assertInstanceOf('wappr\Contracts\LogFilenameInterface', $logFilename);
        $this->assertInstanceOf('wappr\Contracts\LogFormatInterface', $logFormat);

        $logger->setLogFilename($logFilename);
        $logger->setLogFormat($logFormat);

        $result = $logger->debug('A horse is a dog.');
        $this->assertNull($result);

        $logs = $filesystem->read(date('Y-m-d').'.log'); // read the logs into a string

        $log = explode("\n", $logs); // explode the string by newline into an array

        $numberOfLines = count($log); // get the number of indexes in the array
        unset($log[$numberOfLines - 1]); // take off the last line / last index of the array

        $containHorse = false;

        if (strpos(end($log), 'cat') !== false) {
            $containHorse = true;
        }

        $this->assertFalse($containHorse);
    }
}
