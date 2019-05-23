<?php
/**
 * Получение списка юр.клиентов
 */

namespace app\components\actions\client;

use app\components\Clients\ClientsClass;
use Yii;
use yii\base\Action;

class GetUrClientAction extends Action
{
    public function run()
    {
        Yii::info('Запуск функции получения списка юр.клиентов', __METHOD__);

        $resultChange = ClientsClass::GetClientUr();

        if (!is_array($resultChange) || !isset($resultChange['status']) || $resultChange['status'] != 'SUCCESS') {
            Yii::error('Ошибка при получении юр.клиента', __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Ошибка при получении списка юр. лиц',
            ];
        }

        Yii::info('Список юр. лиц успешно получен', __METHOD__);

        return [
            'status' => 'OK',
            'msg' => 'Список юр. лиц успешно получен',
            'data' => $resultChange['data']
        ];
    }
}