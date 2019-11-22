<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use app\components\hire\HireClass;
use app\models\ApplicationEquipment;
use app\models\Applications;
use Yii;
use yii\console\Controller;

class CheckStateHireEqController extends Controller
{
    /**
     * Проверка состояний
     */
    public function actionIndex()
    {
        Yii::info('Запуск функции actionIndex', __METHOD__);

        $app_eq = Applications::find()->where('hire_state_id!=3')->all();

        if (!empty($app_eq)) {
            Yii::info('Есть заявки обрабатываем', __METHOD__);
            /**
             * @var Applications $item
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

        Yii::info('Заявки успешно обработаны', __METHOD__);

        return true;
    }
}
