<?php
/**
 * Получение статусов доставки заявок
 */

namespace app\components\actions\equipments;

use app\components\equipments\ApplicationsClass;
use Yii;
use yii\base\Action;

class GetApplicationsDeliveryAction extends Action
{
    public function run()
    {
        Yii::info('Запуск функции получения статусов доставки заявок', __METHOD__);

        $result = ApplicationsClass::GetApplicationDelivery();

        if (!is_array($result) || !isset($result['status']) || $result['status'] != 'SUCCESS') {
            Yii::error('Ошибка при получении списка статусов доставки заявок', __METHOD__);

            if (is_array($result) && isset($result['status']) && $result['status'] === 'ERROR') {
                return $result;
            }

            return [
                'status' => 'ERROR',
                'msg' => 'Ошибка при получении списка статусов доставки заявок',
            ];
        }

        Yii::info('Список статусов доставки заявок успешно получен', __METHOD__);

        return [
            'status' => 'OK',
            'msg' => 'Список статусов доставки заявок успешно получен',
            'data' => $result['data']
        ];
    }
}