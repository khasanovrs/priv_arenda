<?php
/**
 * Изменение списка полей для финансов
 */

namespace app\components\actions\finance;

use app\components\finance\FinanceClass;
use Yii;
use yii\base\Action;

class ChangeFinanceFieldAction extends Action
{
    public function run()
    {
        Yii::info('Запуск функции изменения списка полей для финансов', __METHOD__);

        $request = Yii::$app->request;

        $params = $request->getBodyParam('data');

        $result = FinanceClass::ChangeFinanceFields($params);

        if (!is_array($result) || !isset($result['status']) || $result['status'] != 'SUCCESS') {
            Yii::error('Ошибка при изменении списка полей для финансов', __METHOD__);

            if (is_array($result) && isset($result['status']) && $result['status'] === 'ERROR') {
                return $result;
            }

            return [
                'status' => 'ERROR',
                'msg' => 'Ошибка при изменении списка полей для финансов',
            ];
        }

        Yii::info('Списки полей для финансов успешно изменены', __METHOD__);

        return [
            'status' => 'OK',
            'msg' => 'Списки полей для финансов успешно изменены'
        ];
    }
}