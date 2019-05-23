<?php
/**
 * Получение статусов
 */

namespace app\components\actions\params;


use app\components\params\ParamsClass;
use Yii;
use yii\base\Action;

class GetStatusAction extends Action
{
    public function run()
    {
        Yii::info('Запуск функции получения статусов', __METHOD__);

        $resultChange = ParamsClass::GetStatus();

        if (!is_array($resultChange) || !isset($resultChange['status']) || $resultChange['status'] != 'SUCCESS') {
            Yii::error('Ошибка при получении статусов', __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Ошибка при получении статусов',
            ];
        }

        Yii::info('Список статусов успешно получен', __METHOD__);

        return [
            'status' => 'OK',
            'msg' => 'Список статусов успешно получен',
            'data' => $resultChange['data']
        ];
    }
}