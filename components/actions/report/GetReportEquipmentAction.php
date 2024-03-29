<?php
/**
 * Получение списка оборудования
 */

namespace app\components\actions\report;

use app\components\report\ReportClass;
use Yii;
use yii\base\Action;

class GetReportEquipmentAction extends Action
{
    public function run()
    {
        Yii::info('Запуск функции получения списка оборудования', __METHOD__);

        $request = Yii::$app->request;

        $branch = $request->getBodyParam('branch');
        $type = $request->getBodyParam('type');

        $result = ReportClass::GetEquipment($branch, $type);

        if (!is_array($result) || !isset($result['status']) || $result['status'] != 'SUCCESS') {
            Yii::error('Ошибка при получении списка оборудования', __METHOD__);

            if (is_array($result) && isset($result['status']) && $result['status'] === 'ERROR') {
                return $result;
            }

            return [
                'status' => 'ERROR',
                'msg' => 'Ошибка при получении списка оборудования',
            ];
        }

        Yii::info('Список оборудования успешно получен', __METHOD__);

        return [
            'status' => 'OK',
            'msg' => 'Список оборудования успешно получен',
            'data' => $result['data']
        ];
    }
}