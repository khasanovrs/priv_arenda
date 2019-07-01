<?php
/**
 * Удаление права
 */

namespace app\components\actions\rights;

use app\components\userRights\UserRightsClass;
use Yii;
use yii\base\Action;

class DeleteRightAction extends Action
{
    public function run()
    {
        Yii::info('Запуск функции удаления права', __METHOD__);

        $request = Yii::$app->request;

        $id = $request->getBodyParam('id');

        $resultChange = UserRightsClass::DeleteRight($id);

        if (!is_array($resultChange) || !isset($resultChange['status']) || $resultChange['status'] != 'SUCCESS') {
            Yii::error('Ошибка при удалении права', __METHOD__);

            if (is_array($resultChange) && isset($resultChange['status']) && $resultChange['status'] === 'ERROR') {
                return $resultChange;
            }

            return [
                'status' => 'ERROR',
                'msg' => 'Ошибка при удалении права',
            ];
        }

        Yii::info('Право успешно удалено', __METHOD__);

        return [
            'status' => 'ОК',
            'msg' => 'Право успешно удалено',
        ];
    }
}