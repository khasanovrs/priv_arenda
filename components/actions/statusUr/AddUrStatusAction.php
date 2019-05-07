<?php
/**
 * Добавление нового статуса для юр.лица
 */

namespace app\components\actions\statusUr;

use app\components\Status\StatusClass;
use Yii;
use yii\base\Action;

class AddUrStatusAction extends Action
{
    public function run()
    {
        Yii::info('Запуск функции добавления нового статуса для юр.лица', __METHOD__);

        $request = Yii::$app->request;

        $name = $request->getBodyParam('name');

        $resultChange = StatusClass::AddUrStatus($name);

        if (!is_array($resultChange) || !isset($resultChange['status']) || $resultChange['status'] != 'SUCCESS') {
            Yii::error('Ошибка при добавлении нового статуса для юр.лица', __METHOD__);

            if (is_array($resultChange) && isset($resultChange['status']) && $resultChange['status'] === 'ERROR') {
                return $resultChange;
            }

            return [
                'status' => 'ERROR',
                'msg' => 'Ошибка при добавлении нового статуса для юр.лица',
            ];
        }

        Yii::info('Статус для юр.лица успешно добавлен', __METHOD__);

        return [
            'status' => 'ОК',
            'msg' => 'Статус успешно добавлен',
        ];
    }
}