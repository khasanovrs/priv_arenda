<?php
/**
 * Управление документами
 */

namespace app\components\documents;

use app\components\finance\FinanceClass;
use app\components\pay\PayClass;
use app\components\Session\Sessions;
use app\models\ApplicationEquipment;
use app\models\Equipments;
use app\models\EquipmentsCategory;
use app\models\EquipmentsField;
use app\models\EquipmentsHistory;
use app\models\EquipmentsHistoryChangeStatus;
use app\models\EquipmentsInfo;
use app\models\EquipmentsMark;
use app\models\EquipmentsShowField;
use app\models\EquipmentsStatus;
use app\models\EquipmentsType;
use app\models\FinanceCashbox;
use app\models\Stock;
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
        $document->setValue('name_v', '777'); //номер договора
        $document->saveAs('test1.docx');

        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="test1.docx"');

        Yii::info('Список типов оборудования получен', __METHOD__);

        return [
            'status' => 'SUCCESS',
            'msg' => 'Список типов оборудования получен',
        ];
    }
}