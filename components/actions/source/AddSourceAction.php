<?php
/**
 * Добавление нового источника
 */

namespace app\components\actions\source;

use app\components\source\SourceClass;
use Yii;
use yii\base\Action;

class AddSourceAction extends Action
{
    public function run()
    {
        Yii::info('Запуск функции добавления нового источника', __METHOD__);

        $request = Yii::$app->request;

        $name = $request->getBodyParam('name');
        $val = $request->getBodyParam('val');

        $resultChange = SourceClass::AddSource($name, $val);

        if (!is_array($resultChange) || !isset($resultChange['status']) || $resultChange['status'] != 'SUCCESS') {
            Yii::error('Ошибка при добавлении нового источника', __METHOD__);

            if (is_array($resultChange) && isset($resultChange['status']) && $resultChange['status'] === 'ERROR') {
                return $resultChange;
            }

            return [
                'status' => 'ERROR',
                'msg' => 'Ошибка при добавлении нового источника',
            ];
        }

        Yii::info('Источник успешно добавлен', __METHOD__);

        return [
            'status' => 'OK',
            'msg' => $resultChange['msg'],
        ];
    }
}