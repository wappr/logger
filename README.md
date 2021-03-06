<p align="center"><a href="https://wappr.co/" target="_blank"><img width="150"src="https://raw.githubusercontent.com/wappr/logger/master/wappr-logo.png"></a></p>

# Logger

[![Build Status](https://travis-ci.org/wappr/logger.svg?branch=master)](https://travis-ci.org/wappr/logger) [![codecov](https://codecov.io/gh/wappr/logger/branch/master/graph/badge.svg)](https://codecov.io/gh/wappr/logger) [![latest stable version](https://poser.pugx.org/wappr/logger/v/stable.svg)](https://packagist.org/packages/wappr/logger) [![license mit](https://poser.pugx.org/wappr/logger/license.svg)](https://packagist.org/packages/wappr/logger)

This logger implements PSR-3, so you can easily replace your current logger with this one.
You can effortlessly keep your log files anywhere since it uses [Flysystem](https://flysystem.thephpleague.com/).


## Installation

The best way to install this package is via composer. You can do it from the command line or 
add `"wappr/logger": "^1.2"` to the required section of your `composer.json`. You can find 
examples of both ways below.

### Composer Command Line

```bash
composer require wappr/logger
```

### Using composer.json

```json
{
  "require": {
    "wappr/logger": "^1.2"
  }
}
```

## Example Usage

### Basic Usage

```php
<?php
include 'vendor/autoload.php';
use League\Flysystem\Filesystem;
use League\Flysystem\Adapter\Local;
use Psr\Log\LogLevel;
use wappr\Logger;

$adapter = new Local(__DIR__.'/storage/logs/');
$filesystem = new Filesystem($adapter);

$logger = new Logger($filesystem, LogLevel::DEBUG);
$logger->info('hello');
```

### Changing Options

```php
<?php
include 'vendor/autoload.php';
use League\Flysystem\Filesystem;
use League\Flysystem\Adapter\Local;
use Psr\Log\LogLevel;
use wappr\Logger;

$adapter = new Local(__DIR__.'/storage/logs/');
$filesystem = new Filesystem($adapter);

$logger = new Logger($filesystem, LogLevel::DEBUG);
$logger->setFilenameFormat('m-d-Y'); // change the format to month day year
$logger->setFilenameExtension('txt'); // change the extension to txt
        
$logger->info('hello');
```

### Using S3 for log storage

```php
<?php
include('vendor/autoload.php');
use Aws\S3\S3Client;
use League\Flysystem\AwsS3v3\AwsS3Adapter;
use League\Flysystem\Filesystem;
use Psr\Log\LogLevel;
use wappr\Logger;

$client = S3Client::factory([
    'credentials' => [
        'key'    => '',
        'secret' => '',
    ],
    'region' => 'us-east-1',
    'version' => 'latest',
]);

$adapter = new AwsS3Adapter($client, 'bucket-name');

$filesystem = new Filesystem($adapter);

$logger = new Logger($filesystem, LogLevel::DEBUG);
$logger->setFilenameFormat('/Ymd/m-d-Y_Gis');
$logger->info('hello');
```

In the above example, it sets the filename to include a directory with the year, month, and day. That way
all newly written files will go in that directory. This is the only way I could think of to overcome the
limitation of S3 not having file locking. Since it is object storage, it does not matter how many directories
or files we have in the bucket.

## License

Copyright (c) 2016 wappr

Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.