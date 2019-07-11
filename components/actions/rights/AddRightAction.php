<?php
/**
 * Добавление нового права
 */

namespace app\components\actions\rights;

use app\components\userRights\UserRightsClass;
use Yii;
use yii\base\Action;

class AddRightAction extends Action
{
    public function run()
    {
        Yii::info('Запуск функции добавления нового источника', __METHOD__);

        $request = Yii::$app->request;

        $name = $request->getBodyParam('name');

        $resultChange = UserRightsClass::AddRight($name);

        if (!is_array($resultChange) || !isset($resultChange['status']) || $resultChange['status'] != 'SUCCESS') {
            Yii::error('Ошибка при добавлении нового права', __METHOD__);

            if (is_array($resultChange) && isset($resultChange['status']) && $resultChange['status'] === 'ERROR') {
                return $resultChange;
            }

            return [
                'status' => 'ERROR',
                'msg' => 'Ошибка при добавлении нового права',
            ];
        }

        Yii::info('Права успешно добавлены', __METHOD__);

        return [
            'status' => 'OK',
            'msg' => 'Права успешно добавлены',
        ];
    }
}