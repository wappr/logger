<?php

use League\Flysystem\Adapter\Local;
use League\Flysystem\Filesystem;
use wappr\LogFilename;
use wappr\Logger;

class LogFilenameTest extends PHPUnit_Framework_TestCase
{
    public function testCreateFilename()
    {
        $expectedResult = date('Y-m-d').'.log';
        $result = LogFilename::create('Y-m-d', 'log');
        $this->assertEquals($expectedResult, $result);
    }

    public function testSettingPropertiesInLogger()
    {
        $adapter = new Local(dirname(__DIR__).'/storage/logs/');
        $filesystem = new Filesystem($adapter);
        $logger = new Logger($filesystem, Psr\Log\LogLevel::INFO);
        $logger->setFilenameFormat('Y-m-d');
        $logger->setFilenameExtension('log');

        $result = $logger->info('A horse is a horse.');
        $this->assertNull($result);

        $logs = $filesystem->read(date('Y-m-d').'.log'); // read the logs into a string

        $log = explode("\n", $logs); // explode the string by newline into an array

        $numberOfLines = count($log); // get the number of indexes in the array
        unset($log[$numberOfLines - 1]); // take off the last line / last index of the array

        $containHorse = false;

        if (strpos(end($log), 'horse') !== false) {
            $containHorse = true;
        }

        $this->assertTrue($containHorse);
    }
}
