<?php

use yii\db\Migration;

/**
 * Class m190607_084725_insert_equem_field
 */
class m190607_084725_insert_equem_field extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("INSERT INTO `equipments_field` (`id`, `code`, `name`) VALUES ('1', 'name', 'Наименование');
            INSERT INTO `equipments_field` (`id`, `code`, `name`) VALUES ('2', 'category', 'Категория');
            INSERT INTO `equipments_field` (`id`, `code`, `name`) VALUES ('3', 'stock', 'Склад');
            INSERT INTO `equipments_field` (`id`, `code`, `name`) VALUES ('4', 'type', 'Тип инструмента');
            INSERT INTO `equipments_field` (`id`, `code`, `name`) VALUES ('5', 'status', 'Доступность');
            INSERT INTO `equipments_field` (`id`, `code`, `name`) VALUES ('7', 'selling_price', 'Цена продажи');
            INSERT INTO `equipments_field` (`id`, `code`, `name`) VALUES ('8', 'price_per_day', 'Цена за сутки');
            INSERT INTO `equipments_field` (`id`, `code`, `name`) VALUES ('9', 'rentals', 'Количество прокатов');
            INSERT INTO `equipments_field` (`id`, `code`, `name`) VALUES ('10', 'repairs', 'Количество ремонтов');
            INSERT INTO `equipments_field` (`id`, `code`, `name`) VALUES ('11', 'repairs_sum', 'Сумма ремонтов');
            INSERT INTO `equipments_field` (`id`, `code`, `name`) VALUES ('12', 'tool_number', 'Номер инструмента');
            INSERT INTO `equipments_field` (`id`, `code`, `name`) VALUES ('13', 'revenue', 'Выручка');
            INSERT INTO `equipments_field` (`id`, `code`, `name`) VALUES ('14', 'profit', 'Прибыль');
            INSERT INTO `equipments_field` (`id`, `code`, `name`) VALUES ('15', 'degree_wear', 'Степень износа ');
            INSERT INTO `equipments_field` (`id`, `code`, `name`) VALUES ('16', 'payback_ratio', 'Коэфициент окупаемости');
        ");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190607_103324_insert_equem_field cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190607_103324_insert_equem_field cannot be reverted.\n";

        return false;
    }
    */
}
