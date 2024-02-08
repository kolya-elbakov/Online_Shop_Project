<?php

namespace Core\Service;

use Throwable;

class LoggerService
{
    public static function logging(Throwable $exception): void
    {
        $message = 'Ошибка в файле: ' . $exception->getFile() . "\n" .
                   'Сообщение: ' . $exception->getMessage() . "\n" .
                   'Строка: ' . $exception->getLine() . "\n" .
                   'Код: ' . $exception->getCode() ;

        $fileName = '/var/www/html/app/Storage/Logs/errors';
//        $fail = fopen($fileName, "a+");
//        fwrite($fail, $message);
//        fclose($fail);
        file_put_contents($fileName, $message, FILE_APPEND);
    }
}
