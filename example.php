<?php

include 'vendor/autoload.php';
use League\Flysystem\Filesystem;
use League\Flysystem\Adapter\Local;
use Psr\Log\LogLevel;
use wappr\Logger;

$adapter = new Local(__DIR__.'/storage/logs/', FILE_APPEND);
$filesystem = new Filesystem($adapter);

$logger = new Logger($filesystem, LogLevel::DEBUG);
$logger->debug('hello');
