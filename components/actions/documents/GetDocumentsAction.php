<?php
/**
 * Получение документов
 */

namespace app\components\actions\documents;

use app\components\documents\DocumentsClass;
use Yii;
use yii\base\Action;

class GetDocumentsAction extends Action
{
    public function run()
    {
        Yii::info('Запуск функции получения документов', __METHOD__);

        $result = DocumentsClass::getDocuments();

        if (!is_array($result) || !isset($result['status']) || $result['status'] != 'SUCCESS') {
            Yii::error('Ошибка при получении списка документов', __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Ошибка при получении документов',
            ];
        }

        Yii::info('Список документов успешно получен', __METHOD__);

        return [
            'status' => 'OK',
            'msg' => 'Список документов успешно получен',
             'data' => $result['data']
        ];
    }
}