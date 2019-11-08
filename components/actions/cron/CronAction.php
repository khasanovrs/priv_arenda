<?php
/**
 * Добавление клиента
 */

namespace app\components\actions\cron;

use app\components\Clients\ClientsClass;
use app\components\hire\HireClass;
use app\models\ApplicationEquipment;
use Yii;
use yii\base\Action;

class CronAction extends Action
{
    public function run()
    {
        Yii::info('Запуск cron', __METHOD__);


        $app_eq = ApplicationEquipment::find()->where('hire_state_id!=3')->all();

        if (!empty($app_eq)) {
            Yii::info('Есть заявки обрабатываем', __METHOD__);
            /**
             * @var ApplicationEquipment $item
             */
            foreach ($app_eq as $item) {
                $result = HireClass::checkHire($item->id);

                if (!is_array($result) || !isset($result['status']) || $result['status'] != 'SUCCESS') {
                    Yii::error('Ошибка при добавлении нового статуса для заявки', __METHOD__);

                    if (is_array($result) && isset($result['status']) && $result['status'] === 'ERROR') {
                        return $result;
                    }

                    return false;
                }
            }
        }

        return [
            'status' => 'OK',
            'msg' => 'Прокаты проверены'
        ];
    }
}