<?php
/**
 * Управление документами
 */

namespace app\components\documents;

use app\models\ApplicationEquipment;
use app\models\ApplicationPay;
use Yii;

class DocumentsClass
{
    /**
     * @return array
     * @throws \PhpOffice\PhpWord\Exception\CopyFileException
     * @throws \PhpOffice\PhpWord\Exception\CreateTemporaryFileException
     */
    public static function getDocuments($id)
    {
        Yii::info('Запуск функции getDocuments', __METHOD__);
        $document = new \PhpOffice\PhpWord\TemplateProcessor('eq_hire.docx'); //шаблон

        /**
         * @var ApplicationEquipment $app_eq
         */
        $app_eq = ApplicationEquipment::find()->where('id=:id', [':id' => $id])->one();

        if (!is_object($app_eq)) {
            Yii::info('Не нашли прокат', __METHOD__);
            return [
                'status' => 'ERROR',
                'msg' => 'Не нашли прокат',
            ];
        }

        $app = $app_eq->application;
        $client = $app->client;

        $mark = $app_eq->equipments->mark0->name;
        $model = $app_eq->equipments->model;
        $type = $app_eq->equipments->type0->name;

        $pay_list_arr = ApplicationPay::find()->where('application_equipment_id=:id', ['id' => $id])->orderBy('id desc')->all();
        $sum_pay = 0;

        if (!empty($pay_list_arr)) {
            /**
             * @var ApplicationPay $value
             */
            foreach ($pay_list_arr as $value) {
                if ($value->cashBox0->check_zalog === '0') {
                    $sum_pay = $sum_pay + $value->sum;
                }
            }
        }

        $datediff = strtotime($app->rent_end) - strtotime($app->rent_start);
        $days = ($datediff / (60 * 60 * 24));

        $document->setValue('id_app_eq', $id);
        $document->setValue('telephone', $client->phone);
        $document->setValue('telephone2', $client->clientsInfos[0]->phone_second);
        $document->setValue('branch', $app->branch->name);
        $document->setValue('date_create_app', date('d.m.Y H:i:s', strtotime($app->date_create)));
        $document->setValue('fio', $client->name);
        $document->setValue('birth', $client->clientsInfos[0]->date_birth);
        $document->setValue('eq', $type . ' ' . $mark . ' ' . $model);
        $document->setValue('eq_sum_per_day', $app_eq->equipments->price_per_day);
        $document->setValue('count_day', $days);
        $document->setValue('hire_start', date('d.m.Y H:i:s', strtotime($app->rent_start)));
        $document->setValue('hire_end', date('d.m.Y H:i:s', strtotime($app->rent_end)));
        $document->setValue('sum_pay', $sum_pay);
        $document->setValue('sum_eq', $app_eq->equipments->selling);

        $document->saveAs('uploads/doc/eq_hire.docx');

        $file = '/uploads/doc/eq_hire.docx';
        header('X-Accel-Redirect: ' . $file);
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename=' . basename($file));

        Yii::info('Список типов оборудования получен', __METHOD__);
        return [
            'status' => 'SUCCESS',
            'msg' => 'Список типов оборудования получен',
            'data' => 'file.docx'
        ];
    }
}