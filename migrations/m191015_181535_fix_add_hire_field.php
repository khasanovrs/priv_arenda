<?php

use yii\db\Migration;

/**
 * Class m191015_181535_fix_add_hire_field
 */
class m191015_181535_fix_add_hire_field extends Migration
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
        $this->execute("INSERT INTO `hire_field` (`id`, `code`, `name`) VALUES ('6', 'state', 'Состояние');");
        $this->execute("INSERT INTO `hire_field` (`id`, `code`, `name`) VALUES ('7', 'sum', 'Цена обрудования');");
        $this->execute("INSERT INTO `hire_field` (`id`, `code`, `name`) VALUES ('8', 'sale_sum', 'Сумма со скидкой');");
        $this->execute("INSERT INTO `hire_field` (`id`, `code`, `name`) VALUES ('9', 'sum_hire', 'Сумма аренды');");
        $this->execute("INSERT INTO `hire_field` (`id`, `code`, `name`) VALUES ('10', 'total_paid', 'Всего оплачено');");
        $this->execute("INSERT INTO `hire_field` (`id`, `code`, `name`) VALUES ('11', 'remainder', 'Остаток');");
        $this->execute("INSERT INTO `hire_field` (`id`, `code`, `name`) VALUES ('12', 'date_create', 'Дата создания');");
        $this->execute("INSERT INTO `hire_field` (`id`, `code`, `name`) VALUES ('13', 'comment', 'Примечание');");
        $this->execute("INSERT INTO `hire_field` (`id`, `code`, `name`) VALUES ('14', 'date_end', 'Дата закрытия');");
        $this->execute("INSERT INTO `hire_field` (`id`, `code`, `name`) VALUES ('15', 'branch', 'Филиал');");
        $this->execute("INSERT INTO `hire_field` (`id`, `code`, `name`) VALUES ('16', 'current_pay', 'Оплачено сегодня');");

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m191015_181535_fix_add_hire_field cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191015_181535_fix_add_hire_field cannot be reverted.\n";

        return false;
    }
    */
}
