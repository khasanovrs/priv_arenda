<?php
/**
 * Получение источников
 */

namespace app\components\actions\params;


use app\components\params\ParamsClass;
use Yii;
use yii\base\Action;

class GetSourceAction extends Action
{
    public function run()
    {
        Yii::info('Запуск функции получения источников', __METHOD__);

        $resultChange = ParamsClass::GetSource();

        if (!is_array($resultChange) || !isset($resultChange['status']) || $resultChange['status'] != 'SUCCESS') {
            Yii::error('Ошибка при получении источников', __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Ошибка при получении источников',
            ];
        }

        Yii::info('Список источников успешно получен', __METHOD__);

        return [
            'status' => 'OK',
            'msg' => 'Список источников успешно получен',
            'data' => $resultChange['data']
        ];
    }
}