<?php
/**
 * Получение данных от приставов
 */

namespace app\components\actions\bailiffs;


use app\components\branch\BranchClass;
use app\components\integration\BailiffsClass;
use Yii;
use yii\base\Action;

class GetBailiffsAction extends Action
{
    public function run()
    {
        Yii::info('Запуск функции получения данных от приставов', __METHOD__);

        $request = Yii::$app->request;
        $fio = $request->getBodyParam('fio');
        $region = $request->getBodyParam('region');
        $type = $request->getBodyParam('type');

        $result = BailiffsClass::getData($fio, $region, $type);

        if (!is_array($result) || !isset($result['status']) || $result['status'] != 'SUCCESS') {
            Yii::error('Ошибка при получении данных от приставов', __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Ошибка при получении данных от приставов',
            ];
        }

        Yii::info('Данные от приставов успешно получены', __METHOD__);

        return [
            'status' => 'OK',
            'msg' => 'Клиент успешно проверен',
            'data' => $result['data']
        ];
    }
}