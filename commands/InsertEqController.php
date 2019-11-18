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

        for ($i = $Start; $i <= 2700; $i++) {
            $r = [];
            $name = $Excel->getActiveSheet()->getCell('A' . $i)->getValue(); // название Makita HR5201C (Дизельная тепловая пушка Master B 150 CED)
            $category = $Excel->getActiveSheet()->getCell('C' . $i)->getValue(); // вид Отбойные молотки
            $tool_number = $Excel->getActiveSheet()->getCell('D' . $i)->getValue(); // серийный номер
            $sum = $Excel->getActiveSheet()->getCell('E' . $i)->getValue(); // Стоимость оборудования 15 000
            $selling_price = $Excel->getActiveSheet()->getCell('F' . $i)->getValue(); // Цена продажи
            $state = $Excel->getActiveSheet()->getCell('G' . $i)->getValue(); // Состояние Списано
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

            if ($state != 'Списано' && $state != 'В наличии' && $state != 'В ремонте') continue;

            if ($category == 'Леса строительные') continue;

            $checkMark = '';

            //ищем марку
            if (strripos(mb_strtolower($name), 'pro lift')) {
                $r[] = 'Pro Lift';
            } elseif (strripos(mb_strtolower($name), 'elekon power')) {
                $r[] = 'ELEKON POWER';
            } elseif (strripos(mb_strtolower($name), 'otto kurtbach')) {
                $r[] = 'OTTO KURTBACH';
            } elseif (strripos(mb_strtolower($name), 'красный маяк')) {
                $r[] = 'Красный Маяк';
            } elseif ($name == 'ЛШМ Sturm BS8580') {
                $r[] = 'Sturm';
            } elseif ($name == 'Затирочная машина по бетону Red Verg RD-S80') {
                $r[] = 'Red Verg';
            } elseif ($name == 'Шнек ADA 150 мм' || $name == 'Шнек ADA 150-300 мм') {
                $r[] = 'ADA';
            } else {
                $r = explode(" ", $name);
            }

            foreach ($r as $value) {
                if ($value === '') continue;
                /**
                 * @var EquipmentsMark $checkMark
                 */

                $checkMarkArr = EquipmentsMark::find()->where(['like', 'lower(name)', mb_strtolower($value)])->all();

                if (empty($checkMarkArr)) {
                    continue;
                }

                if (count($checkMarkArr) > 1) {
                    /**
                     * @var EquipmentsMark $item
                     */
                    foreach ($checkMarkArr as $item) {
                        if (mb_strtolower($item->name) == mb_strtolower($value)) {
                            $checkMark = $item;
                            break;
                        }
                    }
                } else {
                    if (mb_strtolower($checkMarkArr[0]->name) == mb_strtolower($value)) {
                        $checkMark = $checkMarkArr[0];
                        break;
                    }
                }

                if (is_object($checkMark)) {
                    break;
                }
            }

            if (is_object($checkMark) && $branch !== null && $state !== null) {
                $category = trim($category);
                $type = trim(stristr($name, $checkMark->name, true));

                $l = stristr($name, $checkMark->name);
                $model = trim(str_ireplace($checkMark->name, ' ', $l));

                if ($model != '' && $type != '') {
                    // ищем категорию
                    $checkCategory = EquipmentsCategory::find()->where('name=:name', [':name' => mb_strtolower($category)])->one();

                    if (!is_object($checkCategory)) {
                        // добавляем категорию
                        $checkCategory = new EquipmentsCategory();
                        $checkCategory->name = ucfirst(mb_strtolower($category));

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
                    $checkType = EquipmentsType::find()->where('lower(name)=:name and category_id=:category_id', [':name' => mb_strtolower($type), ':category_id' => $checkCategory->id])->one();

                    if (!is_object($checkType)) {
                        // добавляем категорию
                        $checkType = new EquipmentsType();
                        $checkType->name = $type;
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
                    $branch = $branch === 'Казань (Михаила Миля)' ? 'Казань' : $branch;

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
                    $checkState = EquipmentsStatus::find()->where('lower(name)=:name', [':name' => mb_strtolower($state)])->one();
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
                        /*$Excel->getActiveSheet()->removeRow($i, 1);
                        $i--;
                        continue;*/
                        Yii::error('Повтор', __METHOD__);
                    }

                    $date_create = $date_create == null ? date('Y-m-d H:i:s') : date('Y-m-d H:i:s', strtotime($date_create));

                    $newEq = new Equipments();
                    $newEq->status = $checkState->id;
                    $newEq->mark = $checkMark->id;
                    $newEq->model = $model;
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
                    $newEq->date_create = $date_create;
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

                    /*$Excel->getActiveSheet()->removeRow($i, 1);
                    $i--;*/
                } else {
                    if ($type === '') {

                        Yii::error('type: ' . serialize($type), __METHOD__);
                        Yii::error('model: ' . serialize($model), __METHOD__);
                        Yii::error('name: ' . serialize($checkMark->name), __METHOD__);

                        $Excel->getActiveSheet()->setCellValue('U' . $i, 'Нет типа оборудования');
                    } else {
                        $Excel->getActiveSheet()->setCellValue('U' . $i, 'Нет модели оборудования');
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

        /*$fileType = 'Excel5';
        $objWriter = \PHPExcel_IOFactory::createWriter($Excel, $fileType);
        $objWriter->save('eq2.xlsx');*/

        return true;
    }


    /**
     * @return bool
     */
    public function actionInsertMark()
    {
        $markList = 'Makita,Karcher,Hitachi,Master,Champion,Extra,Ballu,Elitech,Huter,Endress,Hyundai,Etalon,Prorab,Ronix,Тепломаш,Doncheng,Remington,Sturm,Daire,Timberk,Калибр,Akvilon,Stihl,Husqvarna,Союз,МАКАР,Wagner,Forza,Wacker,Patriot,ADA,Сплитстоун,Grost,Tsunami,Энергомаш,Красный маяк,Профмаш,Dewalt,Hammer,Wester,Dexter,Rebir,SWL,Jet,Пионер,Умелец,Desa,Sial,ЛРСП,Настил,Bosch,ВСРП,ТСДЗ,RedVerg,Bau,Арсенал,Generac,Инстар,ЛШМ,Garret,Diam Vega,Quattro,ТСС,СТРОЙМАШ,Metabo,Aztec,Saad,Eco,Вихрь,GLANZEN,САИ,СПЕЦ,СФО,Hilti,Тропик,Daewoo,Grinda,ВСП,Griff,Zitrek,SDS-Max,SDS-Plus,TSS,Gesan,Fubag,OTTO KURTBACH,STANLEY,Diam,Carver,ПСРВ,KOLNER,ПАРМА,Kerona,МИCOM,ТТ,ТВ,Циклон,Tor,Elektric,Интерсколл,СИБРТЕХРОС,КЭВ,Kress,Kacher,Профтепло,VEK,Black&Decker,GEOBOX,Sarayli-M,Ryobi,Вагнер,RGK,Cedima,Rothenberger,Sali,Helmut,Marina-Speroni,ПЛЭ,Minelab,Прораб,СПБ,nterra,Печенег,Brait,ELEKON POWER,БРИГ,ГВ,Арктос,Шнек,ТПЦ,Koshin,Valtec,Aurora Pro ORMAN,Equation,Rothenberger,ПСМ,PIT,WIT,Gemini,Testo,Дастпром,КТПТО,Forward,Rolinset,Wet&Dry Vacuum Cleaner,орвет,Biber,ИНСТАН,ПГР,АБП,Sot,ПГУ,V-Cut,Schwamborn,Эйфель,AEG,Standers,Kronwer,Gigant,General,Tesla,Gibli,Grundfos,Honda,Tiger-King,Matrix,Wert,СО,ADA,Леса,Berger,«ВСРП-19900»,Echo,ELEKON POWER,КВТ,Standers,МИСОМ,Archimed,Dongcheng,Ресанта,Ресанта,Etari,Glanzen,Hitachi,IGC,Grinda,МИСОМ,СПЕЦ,Ресанта,Etari,Glanzen,Sturm,Patriot,Стин,Dexter,Красный Маяк,AL-KO,Красный Маяк,ДВ,RedVerg,КВТ,X-Line,КВТ,Stayer,МИСОМ,МИСОМ,Dexell,Stayer,Depo,Ресанта,СПБ,Xintest,КТПТО,Kaskad,Glanzen,Venterra,Бархан,Специалист,Специалист,MLT,Stalex,НЗГА,НЗГА,Вепрь,Dexter,Dexter,ВСРП,УГВКР,BRIMA,КВТ,Красный Маяк,Энергомаш,Makita,RedVerg,Aurora,Ресанта,Grinda,КВТ,Ergus,X-Line,Stayer,Sturm,Сплитстоун,ОКА,Союз,Champion,Patriot,МИСОМ,Wet&Dry,Dongcheng,Wet&Dry,Soteco,ADA,Калибр,СПЕЦ,Ресанта,Ресанта,Ресанта,Ресанта,Ресанта,Ресанта,Aurora,СПБ,СПБ,Сибин,Redverg,Tsunami,Etari,Энкор,КТПТО,КТПТО,Glanzen,Glanzen,Glanzen,Glanzen,Glanzen,ADA,Makita,BauMaster,Dexter,Специалист,Daire,Daire,Daire,Тропик,Профтепло,Профтепло,Профтепло,HammerFlex,Sturm,НОВЭЛ,Конаково,ТСС,ТСС,ТСС,ELEKON POWER,ELEKON POWER,Grinda,МИСОМ,МИСОМ,ECHO,Ресанта,Ресанта,Etari,ECHO,Glanzen,Inforce,SDMO,Техпром,Grinda,REDTRACE,МИСОМ,GeoBox,МИСОМ,Ресанта,Fiorentini,Etari,Glanzen,НЗГА,Сварис,Ресанта,Grinda,REDTRACE,Stayer,МИСОМ,GeoBox,МИСОМ,Archimed,Pro Lift,Ресанта,Ресанта,Xintest,Etari,ТСДЗ,ТСДЗ,Glanzen,Ресанта,ЭРДО,НЗГА,НЗГА,Mur-Cell,Moller,Moller,ELEKON POWER,Фиолент,СЛОН,Stayer,Wira,Фиолент,МИСОМ,НЕВА,МИСОМ,MLT,Dexell,Etari,Profit,Ударник,Hitachi,Зубр,Gardena,Поправил,Grinda,Интерскол,REDTRACE,МИСОМ,GeoBox,МИСОМ,Forapress,Pro Lift,Ресанта,Ресанта,Etari,Простор,Dexter,ELEKON POWER,ELEKON POWER,Stayer,МИСОМ,МИСОМ,МИСОМ,Ресанта,Xintest,Etari,КТПТО,Glanzen,ADA,НОВЭЛ,Специалист,Специалист,СПЕЦ,Ресанта,Glanzen,ELEKON POWER,ELEKON POWER,VEKTOR,CONDTROL,CONDTROL,Автостоп,Автостоп,Stayer,МИСОМ,CONDTROL,МИСОМ,Archimed,Dongcheng,Pro Lift,Pro Lift,Ресанта,Ресанта,Ресанта,Xintest,Etari,КАВИК,Glanzen,REDTRACE,Inforce,Кратон,НЗГА,НЗГА,Сварис,Grinda,Stayer,МИСОМ,МИСОМ,Griff,Ресанта,Ресанта,НОВЭЛ,Etari,UNIVersal,Простор,Grinda,МИСОМ,МИСОМ,Griff,Pro Lift,СПЕЦ,Ресанта,Etari,UNIVersal,ЭРДО,ЭРДО,Прораб,НИЗ,Grinda,Ресанта,CONDTROL,МИСОМ,Радио-Сервис,Радио-Сервис,МИСОМ,Ресанта,UNIVersal,Grinda,МИСОМ,МИСОМ,СПЕЦ,Ресанта,Etari,Edon,Glanzen,ЭРДО,ЭРДО';

        $markArr = explode(",", $markList);

        asort($markArr);

        foreach ($markArr as $value) {
            $checkMark = EquipmentsMark::find()->where('lower(name)=:name', [':name' => mb_strtolower($value)])->one();

            if (is_object($checkMark)) {
                continue;
            }

            $newMark = new EquipmentsMark();
            $newMark->name = ucfirst(mb_strtolower($value));

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
