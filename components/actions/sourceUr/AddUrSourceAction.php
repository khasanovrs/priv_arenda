<?php
/**
 * Добавление нового источника
 */

namespace app\components\actions\sourceUr;

use app\components\Status\StatusClass;
use Yii;
use yii\base\Action;

class AddUrSourceAction extends Action
{
    public function run()
    {
        Yii::info('Запуск функции добавления нового источника', __METHOD__);

        $request = Yii::$app->request;

        $name = $request->getBodyParam('name');

        $resultChange = StatusClass::AddUrSource($name);

        if (!is_array($resultChange) || !isset($resultChange['status']) || $resultChange['status'] != 'SUCCESS') {
            Yii::error('Ошибка при добавлении нового источника', __METHOD__);

            if (is_array($resultChange) && isset($resultChange['status']) && $resultChange['status'] === 'ERROR') {
                return $resultChange;
            }

            return [
                'status' => 'ERROR',
                'msg' => 'Ошибка при добавлении нового источника',
            ];
        }

        Yii::info('Источник успешно добавлен', __METHOD__);

        return [
            'status' => 'ОК',
            'msg' => 'Источник успешно добавлен',
        ];
    }
}