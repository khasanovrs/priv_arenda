<?php
/**
 * Печать документов при создании проката
 */

namespace app\components\actions\documents;

use app\components\documents\DocumentsClass;
use Yii;
use yii\base\Action;

class PrintDocumentsAction extends Action
{
    public function run()
    {
        Yii::info('Запуск функции печати документов при создании проката', __METHOD__);


        $request = Yii::$app->request;

        $branchId = $request->getBodyParam('branch');
        $clientId = $request->getBodyParam('client');
        $eqId = $request->getBodyParam('eq');
        $rent_start = $request->getBodyParam('rent_start');
        $rent_end = $request->getBodyParam('rent_end');
        $payList = $request->getBodyParam('payList');

        $result = DocumentsClass::addDocuments($branchId, $clientId, $eqId, $rent_start, $rent_end, $payList);

        if (!is_array($result) || !isset($result['status']) || $result['status'] != 'SUCCESS') {
            Yii::error('Ошибка при печати документов при создании проката', __METHOD__);

            if (is_array($result) && isset($result['status']) && $result['status'] === 'ERROR') {
                return $result;
            }

            return [
                'status' => 'ERROR',
                'msg' => 'Ошибка при печати документов при создании проката',
            ];
        }

        Yii::info('Документ успешно сформирован', __METHOD__);

        return [
            'status' => 'OK',
            'msg' => 'Документ успешно сформирован',
            'data' => $result['data']
        ];
    }
}