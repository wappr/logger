# Logger

This logger implements PSR-3, so you can easily replace your current logger with this one.
You can easily keep your log files anywhere since it uses [Flysystem](https://flysystem.thephpleague.com/).


## Installation

The best way to install this package is via composer. You can do it from the command line or 
add `"wappr/logger": "0.1.0"` to the required section of your `composer.json`. You can find 
examples for both ways below.

### Composer Command Line

```bash
composer require wappr/logger
```

### Using composer.json

```json
{
  "require": {
    "wappr/logger": "0.1.0"
  }
}
```

## Example Usage

```php
<?php

include 'vendor/autoload.php';
use League\Flysystem\Filesystem;
use League\Flysystem\Adapter\Local;
use Psr\Log\LogLevel;
use wappr\Logger;

$adapter = new Local(__DIR__.'/storage/logs/', FILE_APPEND);
$filesystem = new Filesystem($adapter);

$logger = new Logger($filesystem, LogLevel::DEBUG);
$logger->info('hello');
```

## License

Copyright (c) 2016 wappr

Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.