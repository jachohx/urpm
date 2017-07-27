<?php

namespace App\Listeners;

use Illuminate\Database\Events\QueryExecuted;
use Log, Config, DateTimeZone, DateTime;
use App\Handlers\DBRotatingFileHandler;
use Monolog\Formatter\LineFormatter;

class DatabaseEventListener
{
    public function handle(QueryExecuted $event)
    {
        $dbLog = Config::get('admin.db_log');
        if (true !== $dbLog) return;
        $sql = str_replace("?", "'%s'", $event->sql);
        $log = vsprintf($sql, $event->bindings);
        $timezone = new \DateTimeZone(date_default_timezone_get() ?: 'UTC');
        $ts = DateTime::createFromFormat('U.u', sprintf('%.6F', microtime(true)), $timezone);
        $ts->setTimezone($timezone);

        $record = array(
            'message' => $log,
            'time' => number_format($event->time, 2),
            'context' => [],
            'level' => DBRotatingFileHandler::DB,
            'level_name' => "DB",
            'channel' => Log::getMonolog()->getName(),
            'datetime' => $ts,
            'extra' => array(),
        );

        $formatter = "[%datetime%] %time%ms %level_name%: %message%\n";

        $hander = (new DBRotatingFileHandler(storage_path('/logs/laravel-db.log'), 0, DBRotatingFileHandler::DB, true))
            ->setFormatter(new LineFormatter($formatter, "H:i:s,u", true, true));
        $hander->handle($record);
    }

}