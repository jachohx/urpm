<?php

namespace App\Handlers;

use Monolog\Handler\RotatingFileHandler;

class DBRotatingFileHandler extends RotatingFileHandler
{

    /**
     * Detailed DB information
     */
    const DB = 201;

    /**
     * {@inheritdoc}
     */
    public function isHandling(array $record)
    {
        return $record['level'] >= DBRotatingFileHandler::DB;
    }
}