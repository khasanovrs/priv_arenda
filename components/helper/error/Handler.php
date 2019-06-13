<?php

namespace app\components\helper\error;

use yii\web\ErrorHandler;

/**
 * ErrorHandler handles uncaught PHP errors and exceptions.
 */
class Handler extends ErrorHandler
{
    /**
     * Register this error handler
     */
    public function register()
    {
        ini_set('display_errors', false);
        set_exception_handler([$this, 'handleException']);
        set_error_handler([$this, 'handleError']);
        /*
        if ($this->memoryReserveSize > 0) {
            $this->_memoryReserve = str_repeat('x', $this->memoryReserveSize);
        }*/

        register_shutdown_function([$this, 'handleFatalError']);
    }

}
