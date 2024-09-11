<?php

namespace Tigrino\Core\Errors;

use Throwable;

class ErrorHandler
{
    public function register()
    {
        set_error_handler([$this, 'handleError']);
        set_exception_handler([$this, 'handleException']);
    }

    public function handleError(int $level, string $message, string $file, int $line)
    {
        $this->logError($level, $message, $file, $line);
        http_response_code(500);
    }

    public function handleException(Throwable $exception)
    {
        $this->logException($exception);
        http_response_code(500);
    }

    private function logError(int $level, string $message, string $file, int $line)
    {
        $logMessage = sprintf(
            "[%s] ERROR: %s\n",
            date('Y-m-d H:i:s'),
            "Level: $level | Message: $message | File: $file | Line: $line"
        );
        file_put_contents(__DIR__ . "/../../../Logs/errors.log", $logMessage, FILE_APPEND);
    }

    private function logException(Throwable $exception)
    {
        $exceptionMessage = sprintf(
            "[%s] EXCEPTION: %s\n",
            date('Y-m-d H:i:s'),
            "{$exception->getMessage()} | File: {$exception->getFile()} | Line: {$exception->getLine()}"
        );
        file_put_contents(__DIR__ . "/../../../logs/errors.log", $exceptionMessage, FILE_APPEND);
    }
}
