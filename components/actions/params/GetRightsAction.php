<?php
/**
 * Получение прав
 */

namespace app\components\actions\params;


use app\components\params\ParamsClass;
use Yii;
use yii\base\Action;

class GetRightsAction extends Action
{
    public function run()
    {
        Yii::info('Запуск функции получения прав', __METHOD__);

        $resultChange = ParamsClass::GetRights();

        if (!is_array($resultChange) || !isset($resultChange['status']) || $resultChange['status'] != 'SUCCESS') {
            Yii::error('Ошибка при получении прав', __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Ошибка при получении прав',
            ];
        }

        Yii::info('Список прав успешно получен', __METHOD__);

        return [
            'status' => 'OK',
            'msg' => 'Список прав успешно получен',
            'data' => $resultChange['data']
        ];
    }
}