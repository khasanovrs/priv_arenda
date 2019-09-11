<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use app\components\hire\HireClass;
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

        $result = HireClass::checkHire();

        if (!is_array($result) || !isset($result['status']) || $result['status'] != 'SUCCESS') {
            Yii::error('Ошибка при добавлении нового статуса для заявки', __METHOD__);

            if (is_array($result) && isset($result['status']) && $result['status'] === 'ERROR') {
                return $result;
            }

            return [
                'status' => 'ERROR',
                'msg' => 'Ошибка при проверке статусов заявки',
            ];
        }

        Yii::info('Заявки успешно обработаны', __METHOD__);
    }
}
