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
        $document = new \PhpOffice\PhpWord\TemplateProcessor('test.docx'); //шаблон
        $document->setValue('name_v', '555'); //номер договора
        $document->saveAs('uploads/doc/test1.docx');


        $file = '/uploads/doc/test1.docx';
        header('X-Accel-Redirect: ' . $file);
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename=' . basename($file));



        Yii::info('Список типов оборудования получен', __METHOD__);
        return [
            'status' => 'SUCCESS',
            'msg' => 'Список типов оборудования получен',
            'data' => 'test1.docx'
        ];
    }
}