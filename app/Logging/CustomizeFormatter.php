<?php
namespace App\Logging;

use Monolog\Handler\RotatingFileHandler;
use Monolog\Logger;

class CustomizeFormatter
{
    /**
     * Customize the given logger instance.
     *
     * @param  \Monolog\Logger  $logger
     * @return void
     */
    public function __invoke($logger)
    {
        foreach ($logger->getHandlers() as $handler) {
            if ($handler instanceof RotatingFileHandler) {
                $handler->setFilenameFormat('{date}', 'Y-m-d');
            }
        }
    }
}
