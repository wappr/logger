<?php

namespace wappr\Contracts;

interface LogFormatInterface
{
    public function create($level, $message, array $context = []);
}
