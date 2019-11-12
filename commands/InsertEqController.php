<?php

namespace app\commands;

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
        for ($i= $Start; $i <= 1000; $i++)
        {
            $name = $Excel->getActiveSheet()->getCell('A'.$i )->getValue(); // название Makita HR5201C
            $articul = $Excel->getActiveSheet()->getCell('B'.$i )->getValue(); // артикул
            $type = $Excel->getActiveSheet()->getCell('C'.$i )->getValue(); // вид Отбойные молотки
            $tool_number = $Excel->getActiveSheet()->getCell('D'.$i )->getValue(); // серийный номер
            $type = $Excel->getActiveSheet()->getCell('E'.$i )->getValue(); // Стоимость оборудования 15 000
            $selling_price = $Excel->getActiveSheet()->getCell('F'.$i )->getValue(); // Цена продажи
            $state = $Excel->getActiveSheet()->getCell('G'.$i )->getValue(); // Доступность Списано
            $state_1 = $Excel->getActiveSheet()->getCell('H'.$i )->getValue(); // Состояние Списано
            $price_per_day = $Excel->getActiveSheet()->getCell('I'.$i )->getValue(); // Цена за сутки 500
            $date_create = $Excel->getActiveSheet()->getCell('J'.$i )->getValue(); // Дата создания 14.01.2016
            $branch = $Excel->getActiveSheet()->getCell('K'.$i )->getValue(); // Точка проката Казань (Михаила Миля)
            $foto = $Excel->getActiveSheet()->getCell('L'.$i )->getValue(); // Фото 1
            $hire_count = $Excel->getActiveSheet()->getCell('M'.$i )->getValue(); // Кол-во прокатов
            $repairs_sum = $Excel->getActiveSheet()->getCell('N'.$i )->getValue(); // Прокатов на сумму
            $coment = $Excel->getActiveSheet()->getCell('O'.$i )->getValue(); // Примечание
            $repairs_sum = $Excel->getActiveSheet()->getCell('P'.$i )->getValue(); // Сумма ремонта
            $revenue = $Excel->getActiveSheet()->getCell('Q'.$i )->getValue(); // Доход с оборудования
            $branch = $Excel->getActiveSheet()->getCell('R'.$i )->getValue(); // Филиал
            $date_remont = $Excel->getActiveSheet()->getCell('S'.$i )->getValue(); // Дата ремонта
            $arenda = $Excel->getActiveSheet()->getCell('T'.$i )->getValue(); // В аренде
        }

        return true;
    }
}
