<?php

namespace wappr\Contracts;

interface LogFilenameInterface
{
    public function create($filenameFormat, $filenameExtension);
}
