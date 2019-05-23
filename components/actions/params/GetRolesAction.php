<?php
/**
 * Получение ролей
 */

namespace app\components\actions\params;


use app\components\params\ParamsClass;
use Yii;
use yii\base\Action;

class GetRolesAction extends Action
{
    public function run()
    {
        Yii::info('Запуск функции получения ролей', __METHOD__);

        $resultChange = ParamsClass::GetRoles();

        if (!is_array($resultChange) || !isset($resultChange['status']) || $resultChange['status'] != 'SUCCESS') {
            Yii::error('Ошибка при получении статусов', __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Ошибка при получении ролей',
            ];
        }

        Yii::info('Список ролей успешно получен', __METHOD__);

        return [
            'status' => 'OK',
            'msg' => 'Список ролей успешно получен',
            'data' => $resultChange['data']
        ];
    }
}