<?php

use League\Flysystem\Adapter\Local;
use League\Flysystem\Filesystem;
use wappr\Logger;

class LogLevelTest extends PHPUnit_Framework_TestCase
{
    public function testLogLevels()
    {
        $adapter = new Local(dirname(__DIR__).'/storage/logs/');
        $filesystem = new Filesystem($adapter);

        $logger = new Logger($filesystem, Psr\Log\LogLevel::DEBUG);

        $emergencyResult = $logger->emergency('there is a spider in the house');
        $this->assertNull($emergencyResult);

        $alertResult = $logger->alert('there is a mouse in the house');
        $this->assertNull($alertResult);

        $criticalResult = $logger->critical('there is a dog in the house');
        $this->assertNull($criticalResult);

        $errorResult = $logger->error('there is a house in the house');
        $this->assertNull($errorResult);

        $warningResult = $logger->warning('there is a spider outside the house');
        $this->assertNull($warningResult);

        $noticeResult = $logger->notice('i saw a picture of a spider');
        $this->assertNull($noticeResult);

        $infoResult = $logger->info('i do not like spiders');
        $this->assertNull($infoResult);

        $debugResult = $logger->debug('i would pet a dog');
        $this->assertNull($debugResult);
    }
}
