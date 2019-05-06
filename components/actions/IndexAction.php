<?php
/**
 * Действие по умолчанию
 * Используется для тестирования доступности API
 * Date: 20.10.16
 * Time: 8:40
 */

namespace app\components\actions;

use Yii;
use yii\base\Action;

class IndexAction extends Action
{
    public function run()
    {
        $request = Yii::$app->request;
        if ($request->getBodyParam('make_error') == true) {
            return "THIS ERROR";
        } else {
            return ['status' => 'OK', 'msg' => "API TEST OK"];
        }
    }
}