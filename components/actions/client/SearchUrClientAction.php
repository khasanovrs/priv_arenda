<?php
/**
 * Поиск списка юр.клиентов
 */

namespace app\components\actions\client;

use app\components\Clients\ClientsClass;
use Yii;
use yii\base\Action;

class SearchUrClientAction extends Action
{
    public function run()
    {
        Yii::info('Запуск функции поиска юр.клиентов', __METHOD__);

        $request = Yii::$app->request;

        $param = $request->getBodyParam('name');

        $resultChange = ClientsClass::SearchClientUr($param);

        if (!is_array($resultChange) || !isset($resultChange['status']) || $resultChange['status'] != 'SUCCESS') {
            Yii::error('Ошибка при поиске юр.клиентов', __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Ошибка при поиске юр. лиц',
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