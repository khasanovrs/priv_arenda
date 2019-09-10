<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use app\models\ApplicationEquipment;
use app\models\ApplicationPay;
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

        $arr_eq = ApplicationEquipment::find()->where('hire_state_id!=3')->all();

        if (empty($arr_eq)) {
            Yii::info('Заявки не обноружены', __METHOD__);
            return true;
        }

        /**
         * @var ApplicationEquipment $value
         */
        foreach ($arr_eq as $value) {

        }

        Yii::info('Заявки успешно обработаны', __METHOD__);
    }
}
