<?php
/**
 * Получение полей для таблицы "клиенты"
 */

namespace app\components\actions\client;

use app\components\Clients\ClientsClass;
use Yii;
use yii\base\Action;

class GetFieldsClientAction extends Action
{
    public function run()
    {
        Yii::info('Запуск функции получения полей для таблицы "клиенты"', __METHOD__);

        $result = ClientsClass::GetFields();

        if (!is_array($result) || !isset($result['status']) || $result['status'] != 'SUCCESS') {
            Yii::error('Ошибка при получении полей для таблицы "клиенты"', __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Ошибка при получении полей для таблицы "клиенты"',
            ];
        }

        Yii::info('Список полей успешно получен', __METHOD__);

        return [
            'status' => 'OK',
            'msg' => 'Список полей успешно получен',
            'data' => $result['data']
        ];
    }
}