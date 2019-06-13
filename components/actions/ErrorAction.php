<?php
/**
 * Действие при появлении ошибки
 * Date: 20.10.16
 * Time: 8:40
 */

namespace app\components\actions;

use Yii;
use yii\base\Action;
use yii\base\Exception;
use yii\base\UserException;
use yii\web\HttpException;

class ErrorAction extends Action
{

    /**
     * Runs the action
     *
     * @return array result content
     */
    public function run()
    {
        if (($exception = Yii::$app->getErrorHandler()->exception) === null) {
            // action has been invoked not from error handler, but by direct route, so we display '404 Not Found'
            $exception = new HttpException(404, Yii::t('yii', 'Page not found.'));
        }

        if ($exception instanceof HttpException) {
            $code = $exception->statusCode;
        } else {
            $code = $exception->getCode();
        }
        if ($exception instanceof Exception) {
            $name = $exception->getName();
        } else {
            $name = Yii::t('yii', 'Error');
        }
        if ($code) {
            $name .= " (#$code)";
        }

        if ($exception instanceof UserException) {
            $message = $exception->getMessage();
        } else {
            $message = Yii::t('yii', 'An internal server error occurred.');
        }

        Yii::error("Перехватили Exception $name :: $message :: " /*. serialize($exception)*/, __METHOD__);

        return ['status' => 'ERROR', 'msg' => $message];
    }
}
