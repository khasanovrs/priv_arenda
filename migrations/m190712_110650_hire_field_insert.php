<?php

use yii\db\Migration;

/**
 * Class m190712_110650_hire_field_insert
 */
class m190712_110650_hire_field_insert extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("INSERT INTO `hire_field` (`id`, `code`, `name`) VALUES ('1', 'client', 'Клиент');");
        $this->execute("INSERT INTO `hire_field` (`id`, `code`, `name`) VALUES ('2', 'equipment', 'Оборудование');");
        $this->execute("INSERT INTO `hire_field` (`id`, `code`, `name`) VALUES ('4', 'start_hire', 'Начало аренды');");
        $this->execute("INSERT INTO `hire_field` (`id`, `code`, `name`) VALUES ('5', 'end_hire', 'окончание аренды');");
        $this->execute("INSERT INTO `hire_field` (`id`, `code`, `name`) VALUES ('6', 'status', 'Состояние');");
        $this->execute("INSERT INTO `hire_field` (`id`, `code`, `name`) VALUES ('7', 'sum', 'Цена');");
        $this->execute("INSERT INTO `hire_field` (`id`, `code`, `name`) VALUES ('8', 'sale_sum', 'Сумма со скидкой');");
        $this->execute("INSERT INTO `hire_field` (`id`, `code`, `name`) VALUES ('9', 'total_paid', 'Всего оплачено');");
        $this->execute("INSERT INTO `hire_field` (`id`, `code`, `name`) VALUES ('10', 'remainder', 'Остаток');");
        $this->execute("INSERT INTO `hire_field` (`id`, `code`, `name`) VALUES ('11', 'date_create', 'Дата создания');");
        $this->execute("INSERT INTO `hire_field` (`id`, `code`, `name`) VALUES ('12', 'comment', 'Примечание');");
        $this->execute("INSERT INTO `hire_field` (`id`, `code`, `name`) VALUES ('13', 'date_end', 'Дата закрытия');");
        $this->execute("INSERT INTO `hire_field` (`id`, `code`, `name`) VALUES ('14', 'branch', 'Филиал');");
        $this->execute("INSERT INTO `hire_field` (`id`, `code`, `name`) VALUES ('15', 'current_pay', 'Оплачено сегодня');");

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190712_110650_hire_field_insert cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190712_110650_hire_field_insert cannot be reverted.\n";

        return false;
    }
    */
}
