<?php

use League\Flysystem\Adapter\Local;
use League\Flysystem\Filesystem;
use wappr\Logger;

class LoggerImplementationTest extends PHPUnit_Framework_TestCase
{
    public function testIfItImplementsPsrThree()
    {
        $adapter = new Local(dirname(__DIR__).'/storage/logs/');
        $filesystem = new Filesystem($adapter);
        $logger = new Logger($filesystem, Psr\Log\LogLevel::INFO);
        $this->assertInstanceOf('\Psr\Log\LoggerInterface', $logger);
        $this->assertInstanceOf('\Psr\Log\AbstractLogger', $logger);
    }
}
