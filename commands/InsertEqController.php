<?php

namespace app\commands;

use app\models\EquipmentsMark;
use Yii;
use yii\console\Controller;

class InsertEqController extends Controller
{
    /**
     * Получение данных с excel файла
     */
    public function actionIndex()
    {
        Yii::info('Запуск функции actionIndex', __METHOD__);

        $File = "eq.xlsx";

        $Excel = \PHPExcel_IOFactory::load($File);

        # С какой строки начинаются данные
        $Start = 2;

        $Res = array();
        for ($i = $Start; $i <= 1000; $i++) {
            /*Бензиновый генератор - тип
            Endress   - марка
            ESE 56 BS - модель
            Генераторы - категория*/

            $name = $Excel->getActiveSheet()->getCell('A' . $i)->getValue(); // название Makita HR5201C
            $articul = $Excel->getActiveSheet()->getCell('B' . $i)->getValue(); // артикул
            $type = $Excel->getActiveSheet()->getCell('C' . $i)->getValue(); // вид Отбойные молотки
            $tool_number = $Excel->getActiveSheet()->getCell('D' . $i)->getValue(); // серийный номер
            $type = $Excel->getActiveSheet()->getCell('E' . $i)->getValue(); // Стоимость оборудования 15 000
            $selling_price = $Excel->getActiveSheet()->getCell('F' . $i)->getValue(); // Цена продажи
            $state = $Excel->getActiveSheet()->getCell('G' . $i)->getValue(); // Доступность Списано
            $state_1 = $Excel->getActiveSheet()->getCell('H' . $i)->getValue(); // Состояние Списано
            $price_per_day = $Excel->getActiveSheet()->getCell('I' . $i)->getValue(); // Цена за сутки 500
            $date_create = $Excel->getActiveSheet()->getCell('J' . $i)->getValue(); // Дата создания 14.01.2016
            $branch = $Excel->getActiveSheet()->getCell('K' . $i)->getValue(); // Точка проката Казань (Михаила Миля)
            $foto = $Excel->getActiveSheet()->getCell('L' . $i)->getValue(); // Фото 1
            $hire_count = $Excel->getActiveSheet()->getCell('M' . $i)->getValue(); // Кол-во прокатов
            $repairs_sum = $Excel->getActiveSheet()->getCell('N' . $i)->getValue(); // Прокатов на сумму
            $coment = $Excel->getActiveSheet()->getCell('O' . $i)->getValue(); // Примечание
            $repairs_sum = $Excel->getActiveSheet()->getCell('P' . $i)->getValue(); // Сумма ремонта
            $revenue = $Excel->getActiveSheet()->getCell('Q' . $i)->getValue(); // Доход с оборудования
            $branch = $Excel->getActiveSheet()->getCell('R' . $i)->getValue(); // Филиал
            $date_remont = $Excel->getActiveSheet()->getCell('S' . $i)->getValue(); // Дата ремонта
            $arenda = $Excel->getActiveSheet()->getCell('T' . $i)->getValue(); // В аренде
        }

        return true;
    }


    /**
     * @return bool
     */
    public function actionInsertMark()
    {
        $markList = 'Makita,Karcher,Hitachi,Master,Champion,Extra,Ballu,Elitech,Huter,Endress,Hyundai,Etalon,Prorab,Ronix,Тепломаш,Doncheng,Remington,Sturm,Daire,Timberk,Калибр,Akvilon,Stihl,Husqvarna,Союз,МАКАР,Wagner,Forza,Wacker,Patriot,ADA,Сплитстоун,Grost,Tsunami,Энергомаш,Красный маяк,Профмаш,Dewalt,Hammer,Wester,Bosh,Dexter,Rebir,SWL,Jet,Пионер,Умелец,Desa,Sial,ЛРСП,Настил,Bosch,ВСРП,ТСДЗ,RedVerg,Bau,Арсенал,Generac,Инстар,ЛШМ,Garret,Diam Vega,Quattro,ТСС,СТРОЙМАШ,Metabo,Aztec,Saad,Eco,Вихрь,GLANZEN,САИ,СПЕЦ,СФО,Hilti,Тропик,Daewoo,Grinda,ВСП,Griff,Zitrek,SDS-Max,SDS-Plus,TSS,Gesan,Fubag,OTTO KURTBACH,STANLEY,Diam,Carver,ПСРВ,KOLNER,ПАРМА,Kerona,МИCOM,ТТ,ТВ,Циклон,Tor,Elektric,Интерсколл,СИБРТЕХРОС,КЭВ,Kress,Kacher,Профтепло,VEK,Black&Decker,GEOBOX,Sarayli-M,Ryobi,Вагнер,RGK,Cedima,Rothenberger,Sali,Helmut,Marina-Speroni,ПЛЭ,Minelab,Прораб,СПБ,nterra,Печенег,Brait,ELEKON POWER,БРИГ,ГВ,Арктос,Шнек,ТПЦ,Koshin,Valtec,Aurora Pro ORMAN,Equation,Rothenberger,ПСМ,PIT,WIT,Gemini,Testo,Дастпром,КТПТО,Forward,Rolinset,Wet&Dry Vacuum Cleaner,орвет,Biber,ИНСТАН,ПГР,АБП,Sot,ПГУ,V-Cut,Schwamborn,Эйфель,AEG,Standers,Kronwer,Gigant,General,Tesla,Gibli,Grundfos,Honda,Tiger-King,Matrix,Wert';

        $markArr = explode(",", $markList);

        asort($markArr);

        foreach ($markArr as $value) {
            $checkMark = EquipmentsMark::find()->where('lower(name)=:name', [':name' => strtolower($value)])->one();

            if (is_object($checkMark)) {
                continue;
            }

            $newMark = new EquipmentsMark();
            $newMark->name = ucfirst(strtolower($value));

            try {
                if (!$newMark->save(false)) {
                    Yii::error('Ошибка при сохранении марок: ' . serialize($newMark->getErrors()), __METHOD__);
                    return false;
                }
            } catch (\Exception $e) {
                Yii::error('Поймали Exception при сохранении марок: ' . serialize($e->getMessage()), __METHOD__);
                return false;
            }

        }

        return true;
    }
}
