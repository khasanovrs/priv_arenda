<?php

namespace app\commands;

use app\models\Branch;
use app\models\Equipments;
use app\models\EquipmentsCategory;
use app\models\EquipmentsInfo;
use app\models\EquipmentsMark;
use app\models\EquipmentsStatus;
use app\models\EquipmentsType;
use app\models\Stock;
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

        for ($i = $Start; $i <= 5000; $i++) {
            $name = $Excel->getActiveSheet()->getCell('A' . $i)->getValue(); // название Makita HR5201C (Дизельная тепловая пушка Master B 150 CED)
            $category = $Excel->getActiveSheet()->getCell('C' . $i)->getValue(); // вид Отбойные молотки
            $tool_number = $Excel->getActiveSheet()->getCell('D' . $i)->getValue(); // серийный номер
            $sum = $Excel->getActiveSheet()->getCell('E' . $i)->getValue(); // Стоимость оборудования 15 000
            $selling_price = $Excel->getActiveSheet()->getCell('F' . $i)->getValue(); // Цена продажи
            $state = $Excel->getActiveSheet()->getCell('H' . $i)->getValue(); // Состояние Списано
            $price_per_day = $Excel->getActiveSheet()->getCell('I' . $i)->getValue(); // Цена за сутки 500
            $date_create = $Excel->getActiveSheet()->getCell('J' . $i)->getValue(); // Дата создания 14.01.2016
            $foto = $Excel->getActiveSheet()->getCell('L' . $i)->getValue(); // Фото 1
            $hire_count = $Excel->getActiveSheet()->getCell('M' . $i)->getValue(); // Кол-во прокатов
            $coment = $Excel->getActiveSheet()->getCell('O' . $i)->getValue(); // Примечание
            $repairs_sum = $Excel->getActiveSheet()->getCell('P' . $i)->getValue(); // Сумма ремонта
            $revenue = $Excel->getActiveSheet()->getCell('Q' . $i)->getValue(); // Доход с оборудования
            $branch = $Excel->getActiveSheet()->getCell('R' . $i)->getValue(); // Филиал
            $arenda = $Excel->getActiveSheet()->getCell('T' . $i)->getValue(); // В аренде


            if ($name === null) continue;

            //ищем марку
            $checkMark = '';
            $r = explode(" ", $name);

            foreach ($r as $value) {
                if ($value === '') continue;
                /**
                 * @var EquipmentsMark $checkMark
                 */
                $checkMark = EquipmentsMark::find()->where(['in', 'lower(name)', mb_strtolower($value)])->one();

                if (is_object($checkMark)) {
                    break;
                }
            }

            if (is_object($checkMark) && $branch !== null && $state !== null) {

                $ll = explode(' ' . mb_strtolower($checkMark->name) . ' ', mb_strtolower($name));
                $category = trim($category);

                if (isset($ll[0]) && isset($ll[1])) {
                    $type = $ll[0];
                    $model = $ll[1];

                    // ищем категорию
                    $checkCategory = EquipmentsCategory::find()->where('name=:name', [':name' => strtolower($category)])->one();

                    if (!is_object($checkCategory)) {
                        // добавляем категорию
                        $checkCategory = new EquipmentsCategory();
                        $checkCategory->name = ucfirst(strtolower($category));

                        try {
                            if (!$checkCategory->save(false)) {
                                Yii::error('Ошибка при сохранении категории: ' . serialize($checkCategory->getErrors()), __METHOD__);
                                return false;
                            }
                        } catch (\Exception $e) {
                            Yii::error('Поймали Exception при сохранении категории: ' . serialize($e->getMessage()), __METHOD__);
                            return false;
                        }
                    }

                    // ищем тип
                    $checkType = EquipmentsType::find()->where('name=:name and category_id=:category_id', [':name' => ucfirst(strtolower($type)), ':category_id' => $checkCategory->id])->one();

                    if (!is_object($checkType)) {
                        // добавляем категорию
                        $checkType = new EquipmentsType();
                        $checkType->name = ucfirst(strtolower($type));
                        $checkType->category_id = $checkCategory->id;

                        try {
                            if (!$checkType->save(false)) {
                                Yii::error('Ошибка при сохранении типа: ' . serialize($checkType->getErrors()), __METHOD__);
                                return false;
                            }
                        } catch (\Exception $e) {
                            Yii::error('Поймали Exception при сохранении типа: ' . serialize($e->getMessage()), __METHOD__);
                            return false;
                        }
                    }

                    // поиск филиала
                    $branch = $branch === 'Казань (ММ)' ? 'Казань' : $branch;

                    /**
                     * @var Branch $checkBranch
                     */

                    $checkBranch = Branch::find()->where('name=:name', [':name' => $branch])->one();
                    if (!is_object($checkBranch)) {
                        Yii::error('Филиал не найден: ' . serialize($branch), __METHOD__);
                        return false;
                    }

                    /**
                     * @var Stock $checkStock
                     */
                    $checkStock = $checkBranch->stocks;
                    if (empty($checkStock)) {
                        Yii::error('Склад не найден: ' . serialize($branch), __METHOD__);
                        return false;
                    }

                    // поиск состояния
                    /**
                     * @var EquipmentsStatus $checkState
                     */
                    $state = $state === 'Списано' ? 'Списан' : $state;
                    $state = $state === 'В наличии' ? 'Доступен' : $state;
                    $state = $state === 'Просрочен' ? 'В аренде' : $state;
                    $checkState = EquipmentsStatus::find()->where('name=:name', [':name' => strtolower($state)])->one();
                    if (!is_object($checkState)) {
                        Yii::error('Состояние не найдено: ' . serialize($state), __METHOD__);
                        return false;
                    }

                    // очищаем серийный номер от лишних символов
                    $tool_number = str_replace("№", "", $tool_number);

                    // ищем тип
                    $checkEq = Equipments::find()->where(
                        'mark=:mark and model=:model and stock_id=:stock_id and category_id=:category_id and type=:type', [':mark' => $checkMark->id, ':model' => $model, ':stock_id' => $checkStock[0]->id, ':category_id' => $checkCategory->id, ':type' => $checkType->id])->one();

                    if (is_object($checkEq)) {
                        $Excel->getActiveSheet()->removeRow($i,1);
                        $i--;
                        continue;
                    }

                    $newEq = new Equipments();
                    $newEq->status = $checkState->id;
                    $newEq->mark = $checkMark->id;
                    $newEq->model = ucfirst(strtolower($model));
                    $newEq->stock_id = $checkStock[0]->id;
                    $newEq->type = $checkType->id;
                    $newEq->category_id = $checkCategory->id;
                    $newEq->tool_number = $tool_number;
                    $newEq->selling = $sum;
                    $newEq->selling_price = $selling_price;
                    $newEq->price_per_day = $price_per_day;
                    $newEq->revenue = $revenue;
                    $newEq->degree_wear = 0;
                    $newEq->countHire = $hire_count || 0;
                    $newEq->discount = 1;
                    $newEq->date_create = date('Y-m-d H:i:s', strtotime($date_create));
                    $newEq->rentals = $arenda;
                    $newEq->repairs = 0;
                    $newEq->repairs_sum = $repairs_sum;
                    $newEq->profit = $revenue - $sum - $repairs_sum;
                    $newEq->payback_ratio = 0;
                    $newEq->photo = $foto;
                    $newEq->photo_alias = '';
                    $newEq->confirmed = 1;

                    try {
                        if (!$newEq->save(false)) {
                            Yii::error('Ошибка при сохранении оборудования: ' . serialize($newEq->getErrors()), __METHOD__);
                            return false;
                        }
                    } catch (\Exception $e) {
                        Yii::error('Поймали Exception при сохранении оборудования: ' . serialize($e->getMessage()), __METHOD__);
                        return false;
                    }

                    $newEquipmentsInfo = new EquipmentsInfo();
                    $newEquipmentsInfo->equipments_id = $newEq->id;
                    $newEquipmentsInfo->power_energy = 0;
                    $newEquipmentsInfo->length = 0;
                    $newEquipmentsInfo->network_cord = 0;
                    $newEquipmentsInfo->power = 0;
                    $newEquipmentsInfo->comment = $coment;
                    $newEquipmentsInfo->frequency_hits = 0;

                    try {
                        if (!$newEquipmentsInfo->save(false)) {
                            Yii::error('Ошибка при добавлении дополнительной информации об оборудовании: ' . serialize($newEquipmentsInfo->getErrors()), __METHOD__);
                            return false;
                        }
                    } catch (\Exception $e) {
                        Yii::error('Поймали Exception при добавлении дополнительной информации об оборудовании: ' . serialize($e->getMessage()), __METHOD__);
                        return false;
                    }

                    $Excel->getActiveSheet()->removeRow($i,1);
                    $i--;
                } else {
                    Yii::error('ololo ' . serialize($ll), __METHOD__);
                    if (!isset($ll[0])) {
                        $Excel->getActiveSheet()->setCellValue('U' . $i, 'Нет типа оборудования');
                    } else {
                        $Excel->getActiveSheet()->setCellValue('U' . $i, 'Нет марки оборудования');
                    }
                }
            } else {
                if ($branch === null) {
                    $Excel->getActiveSheet()->setCellValue('U' . $i, 'Нет филиала');
                } elseif ($state === null) {
                    $Excel->getActiveSheet()->setCellValue('U' . $i, 'Нет состояния');
                } else {
                    $Excel->getActiveSheet()->setCellValue('U' . $i, 'Не нашли марку в БД');
                }
            }
        }

        /*$ch = 0;

        for ($j = 2; $j <= 2000; ++$j) {
            Yii::info('zzzzz: ' . serialize($j), __METHOD__);

            $check = $Excel->getActiveSheet()->getCell('U' . $j)->getValue(); // название Makita HR5201C (Дизельная тепловая пушка Master B 150 CED)
            $checkName = $Excel->getActiveSheet()->getCell('A' . $j)->getValue(); // название Makita HR5201C (Дизельная тепловая пушка Master B 150 CED)


            if ($checkName != null && $check === null && $ch<200) {
                Yii::info('ololo: ' . serialize($j), __METHOD__);
                $Excel->getActiveSheet()->removeRow($j,1);
                $ch++;
                --$j;
            }
        }*/

        $fileType = 'Excel5';
        $objWriter = \PHPExcel_IOFactory::createWriter($Excel, $fileType);
        $objWriter->save('eq2.xlsx');

        return true;
    }


    /**
     * @return bool
     */
    public function actionInsertMark()
    {
        $markList = 'Makita,Karcher,Hitachi,Master,Champion,Extra,Ballu,Elitech,Huter,Endress,Hyundai,Etalon,Prorab,Ronix,Тепломаш,Doncheng,Remington,Sturm,Daire,Timberk,Калибр,Akvilon,Stihl,Husqvarna,Союз,МАКАР,Wagner,Forza,Wacker,Patriot,ADA,Сплитстоун,Grost,Tsunami,Энергомаш,Красный маяк,Профмаш,Dewalt,Hammer,Wester,Dexter,Rebir,SWL,Jet,Пионер,Умелец,Desa,Sial,ЛРСП,Настил,Bosch,ВСРП,ТСДЗ,RedVerg,Bau,Арсенал,Generac,Инстар,ЛШМ,Garret,Diam Vega,Quattro,ТСС,СТРОЙМАШ,Metabo,Aztec,Saad,Eco,Вихрь,GLANZEN,САИ,СПЕЦ,СФО,Hilti,Тропик,Daewoo,Grinda,ВСП,Griff,Zitrek,SDS-Max,SDS-Plus,TSS,Gesan,Fubag,OTTO KURTBACH,STANLEY,Diam,Carver,ПСРВ,KOLNER,ПАРМА,Kerona,МИCOM,ТТ,ТВ,Циклон,Tor,Elektric,Интерсколл,СИБРТЕХРОС,КЭВ,Kress,Kacher,Профтепло,VEK,Black&Decker,GEOBOX,Sarayli-M,Ryobi,Вагнер,RGK,Cedima,Rothenberger,Sali,Helmut,Marina-Speroni,ПЛЭ,Minelab,Прораб,СПБ,nterra,Печенег,Brait,ELEKON POWER,БРИГ,ГВ,Арктос,Шнек,ТПЦ,Koshin,Valtec,Aurora Pro ORMAN,Equation,Rothenberger,ПСМ,PIT,WIT,Gemini,Testo,Дастпром,КТПТО,Forward,Rolinset,Wet&Dry Vacuum Cleaner,орвет,Biber,ИНСТАН,ПГР,АБП,Sot,ПГУ,V-Cut,Schwamborn,Эйфель,AEG,Standers,Kronwer,Gigant,General,Tesla,Gibli,Grundfos,Honda,Tiger-King,Matrix,Wert,СО,ADA,Леса,Berger,«ВСРП-19900»';

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
