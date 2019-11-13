<?php
/**
 * Управление документами
 */

namespace app\components\documents;

use Yii;

class DocumentsClass
{
    /**
     * @return array
     * @throws \PhpOffice\PhpWord\Exception\CopyFileException
     * @throws \PhpOffice\PhpWord\Exception\CreateTemporaryFileException
     */
    public static function getDocuments()
    {
        Yii::info('Запуск функции getDocuments', __METHOD__);
        $document = new \PhpOffice\PhpWord\TemplateProcessor('eq_hire.docx'); //шаблон


        $document->setValue('id_app_eq', '');
        $document->setValue('telephone', '');
        $document->setValue('telephone2', '');
        $document->setValue('branch', '');
        $document->setValue('date_create_app', '');
        $document->setValue('fio', '');
        $document->setValue('birth', '');
        $document->setValue('eq', '');
        $document->setValue('eq_sum_per_day', '');
        $document->setValue('count_day', '');
        $document->setValue('hire_start', '');
        $document->setValue('hire_end', '');
        $document->setValue('sum_pay', '');
        $document->setValue('sum_eq', '');


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