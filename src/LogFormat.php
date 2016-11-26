<?php

namespace wappr;

/**
 * Class LogFormat.
 */
class LogFormat
{
    /**
     * The filename is the current date with the extension '.log'.
     *
     * @var string
     */
    protected $filename;

    /**
     * The message that is being written to the log file.
     *
     * @var string
     */
    protected $message;

    /**
     * LogFormat constructor.
     *
     * @param string $level
     * @param string $message
     * @param array  $context
     */
    public function __construct($level, $message, array $context = [])
    {
        // Set the filename to the current date. Ex. 2016-11-25.log
        $this->filename = date('Y-m-d').'.log';

        // Get milliseconds
        $ms = explode('.', microtime(true))[1];

        // Assemble the message. Ex. [debug] [2016-11-25 15:37:36.9468] hello
        $this->message = '['.$level.'] ['.date('Y-m-d G:i:s').'.'.$ms.'] '.$message;

        // If an array was passed as well, serialize it and add it's content.
        // @TODO: find a cleaner way to do this
        if (count($context) > 0) {
            $this->message .= ' '.serialize($context);
        }
    }

    /**
     * @return string
     */
    public function filename()
    {
        return $this->filename;
    }

    /**
     * @return string
     */
    public function message()
    {
        return $this->message;
    }
}
