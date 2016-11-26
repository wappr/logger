<?php

use League\Flysystem\Adapter\Local;
use League\Flysystem\Filesystem;
use wappr\Logger;

class InterpolateTest extends PHPUnit_Framework_TestCase
{
    public function testInterpolate()
    {
        $adapter = new Local(dirname(__DIR__).'/storage/logs/');
        $filesystem = new Filesystem($adapter);
        $logger = new Logger($filesystem, Psr\Log\LogLevel::INFO);

        $values = [
            'animal' => 'cat',
        ];

        $logger->info('A horse is a {animal}.', $values);

        $logs = $filesystem->read(date('Y-m-d').'.log'); // read the logs into a string

        $containsCat = false;

        if (strpos($logs, 'cat') !== false) {
            $containsCat = true;
        }

        $this->assertTrue($containsCat);
    }
}
