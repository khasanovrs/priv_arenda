<?php
/**
 * Управление документами
 */

namespace app\components\documents;

use app\models\ApplicationEquipment;
use app\models\ApplicationPay;
use app\models\Branch;
use app\models\Clients;
use app\models\Equipments;
use app\models\FinanceCashbox;
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

        $document->setValue('id_app_eq', $app->id);
        $document->setValue('telephone', $client->phone);
        $document->setValue('telephone2', $client->clientsInfos[0]->phone_second);
        $document->setValue('branch', $app->branch->name);
        $document->setValue('date_create_app', date('d.m.Y H:i:s', strtotime($app->date_create)));
        $document->setValue('date_create_app_2', date('d.m.Y', strtotime($app->date_create)));
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

        /*$file = '/uploads/doc/eq_hire.docx';
        header('X-Accel-Redirect: ' . $file);
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename=' . basename($file));*/

        Yii::info('Список типов оборудования получен', __METHOD__);
        return [
            'status' => 'SUCCESS',
            'msg' => 'Список типов оборудования получен',
            'data' => 'eq_hire.docx'
        ];
    }

    /**
     * Печать документа при создании проката
     * @param $branchId
     * @param $clientId
     * @param $eqId
     * @param $rent_start
     * @param $rent_end
     * @param $payList
     * @return array
     * @throws \PhpOffice\PhpWord\Exception\CopyFileException
     * @throws \PhpOffice\PhpWord\Exception\CreateTemporaryFileException
     */
    public static function addDocuments($branchId, $clientId, $eqId, $rent_start, $rent_end, $payList)
    {
        Yii::info('Запуск функции getDocuments', __METHOD__);
        $document = new \PhpOffice\PhpWord\TemplateProcessor('eq_hire.docx'); //шаблон

        /**
         * @var Branch $branch
         */
        $branch = Branch::find()->where('id=:id', [':id' => $branchId])->one();
        if (!is_object($branch)) {
            Yii::info('Не указан филиал', __METHOD__);
            return [
                'status' => 'ERROR',
                'msg' => 'Не указан филиал'
            ];
        }

        /**
         * @var Clients $client
         */
        $client = Clients::find()->where('id=:id', [':id' => $clientId])->one();
        if (!is_object($client)) {
            Yii::info('Не указан клиент', __METHOD__);
            return [
                'status' => 'ERROR',
                'msg' => 'Не указан клиент'
            ];
        }

        /**
         * @var Equipments $equipments
         */
        $equipments = Equipments::find()->where('id=:id', [':id' => $eqId])->one();
        if (!is_object($equipments)) {
            Yii::info('Не указан клиент', __METHOD__);
            return [
                'status' => 'ERROR',
                'msg' => 'Не указан клиент'
            ];
        }

        $mark = $equipments->mark0->name;
        $model = $equipments->model;
        $type = $equipments->type0->name;

        $sum_pay = 0;

        if (!empty($payList)) {

            foreach ($payList as $value) {
                /**
                 * @var FinanceCashbox $cashBox
                 */
                $cashBox = FinanceCashbox::find()->where('id=:id', [':id' => $value->cashBox])->one();
                if (!is_object($cashBox)) {
                    Yii::info('Не указана касса', __METHOD__);
                    return [
                        'status' => 'ERROR',
                        'msg' => 'Не указана касса'
                    ];
                }

                if ($cashBox->check_zalog === '0' && !$value->revertSum) {
                    $sum_pay = $sum_pay + $value->sum;
                }
            }
        }

        $dateDiff = strtotime($rent_end) - strtotime($rent_start);
        $days = ($dateDiff / (60 * 60 * 24));

        $id_app_eq = substr($branch->name, 0, 1) + date('ymd') + $equipments->id;

        $document->setValue('id_app_eq', $id_app_eq);
        $document->setValue('telephone', $client->phone);
        $document->setValue('telephone2', $client->clientsInfos[0]->phone_second);
        $document->setValue('branch', $branch->name);
        $document->setValue('date_create_app', date('d.m.Y H:i:s'));
        $document->setValue('date_create_app_2', date('d.m.Y'));
        $document->setValue('fio', $client->name);
        $document->setValue('birth', $client->clientsInfos[0]->date_birth);
        $document->setValue('eq', $type . ' ' . $mark . ' ' . $model);
        $document->setValue('eq_sum_per_day', $equipments->price_per_day);
        $document->setValue('count_day', $days);
        $document->setValue('hire_start', date('d.m.Y H:i:s', strtotime($rent_start)));
        $document->setValue('hire_end', date('d.m.Y H:i:s', strtotime($rent_end)));
        $document->setValue('sum_pay', $sum_pay);
        $document->setValue('sum_eq', $equipments->selling);

        $document->saveAs('uploads/doc/' . $id_app_eq . '.docx');

        Yii::info('Список типов оборудования получен', __METHOD__);
        return [
            'status' => 'SUCCESS',
            'msg' => 'Список типов оборудования получен',
            'data' => $id_app_eq . '.docx'
        ];


    }
}