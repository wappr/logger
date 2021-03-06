<?php

use League\Flysystem\Adapter\Local;
use League\Flysystem\Filesystem;
use wappr\Logger;

class WriteToFileTest extends PHPUnit_Framework_TestCase
{
    public function testWritingToFile()
    {
        $adapter = new Local(dirname(__DIR__).'/storage/logs/');
        $filesystem = new Filesystem($adapter);
        $logger = new Logger($filesystem, Psr\Log\LogLevel::INFO);

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

    public function testNotWritingToFile()
    {
        $adapter = new Local(dirname(__DIR__).'/storage/logs/');
        $filesystem = new Filesystem($adapter);
        $logger = new Logger($filesystem, Psr\Log\LogLevel::INFO);

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

    public function testWritingArrayToFile()
    {
        $adapter = new Local(dirname(__DIR__).'/storage/logs/');
        $filesystem = new Filesystem($adapter);
        $logger = new Logger($filesystem, Psr\Log\LogLevel::INFO);

        $horses = [
            'spirit',
            'iron maiden',
            'juniper',
        ];

        $result = $logger->info('A horse is a horse.', $horses);
        $this->assertNull($result);

        $logs = $filesystem->read(date('Y-m-d').'.log'); // read the logs into a string

        $containsArray = false;

        if (strpos($logs, 'Array') !== false) {
            $containsArray = true;
        }

        $this->assertTrue($containsArray);
    }
}
