<?php

use yii\db\Migration;

/**
 * Class m191119_054407_insert_hire_lesa_field
 */
class m191119_054407_insert_hire_lesa_field extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("INSERT INTO `hire_lesa_field` (`id`, `code`, `name`) VALUES ('1', 'client', 'Клиент');
INSERT INTO `hire_lesa_field` (`id`, `code`, `name`) VALUES ('2', 'equipment', 'Оборудование');
INSERT INTO `hire_lesa_field` (`id`, `code`, `name`) VALUES ('4', 'start_hire', 'Начало аренды');
INSERT INTO `hire_lesa_field` (`id`, `code`, `name`) VALUES ('5', 'end_hire', 'окончание аренды');
INSERT INTO `hire_lesa_field` (`id`, `code`, `name`) VALUES ('6', 'state', 'Состояние');
INSERT INTO `hire_lesa_field` (`id`, `code`, `name`) VALUES ('7', 'sum', 'Цена обрудования');
INSERT INTO `hire_lesa_field` (`id`, `code`, `name`) VALUES ('8', 'sale_sum', ' Цена обрудования со скидкой');
INSERT INTO `hire_lesa_field` (`id`, `code`, `name`) VALUES ('9', 'sum_hire', 'Сумма аренды');
INSERT INTO `hire_lesa_field` (`id`, `code`, `name`) VALUES ('10', 'total_paid', 'Всего оплачено');
INSERT INTO `hire_lesa_field` (`id`, `code`, `name`) VALUES ('11', 'remainder', 'Остаток');
INSERT INTO `hire_lesa_field` (`id`, `code`, `name`) VALUES ('12', 'date_create', 'Дата создания');
INSERT INTO `hire_lesa_field` (`id`, `code`, `name`) VALUES ('13', 'comment', 'Примечание');
INSERT INTO `hire_lesa_field` (`id`, `code`, `name`) VALUES ('14', 'date_end', 'Дата закрытия');
INSERT INTO `hire_lesa_field` (`id`, `code`, `name`) VALUES ('15', 'branch', 'Филиал');
INSERT INTO `hire_lesa_field` (`id`, `code`, `name`) VALUES ('16', 'current_pay', 'Оплачено сегодня');
INSERT INTO `hire_lesa_field` (`id`, `code`, `name`) VALUES ('17', 'id_dog', 'Номер договора');
INSERT INTO `hire_lesa_field` (`id`, `code`, `name`) VALUES ('18', 'delivery_sum', 'Сумма доставки');
INSERT INTO `hire_lesa_field` (`id`, `code`, `name`) VALUES ('19', 'delivery_sum_paid', 'Сумма доставки оплачено');
INSERT INTO `hire_lesa_field` (`id`, `code`, `name`) VALUES ('20', 'rama_prokhodnaya', 'Рама проходная');
INSERT INTO `hire_lesa_field` (`id`, `code`, `name`) VALUES ('21', 'rama_letsnitsey', 'Рама с летсницей');
INSERT INTO `hire_lesa_field` (`id`, `code`, `name`) VALUES ('22', 'diagonalnaya_svyaz', 'Диагональная связь');
INSERT INTO `hire_lesa_field` (`id`, `code`, `name`) VALUES ('23', 'gorizontalnaya_svyaz', 'Горизонтальная связь');
INSERT INTO `hire_lesa_field` (`id`, `code`, `name`) VALUES ('24', 'rigel', 'Ригель');
INSERT INTO `hire_lesa_field` (`id`, `code`, `name`) VALUES ('25', 'nastil', 'Настил');
");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m191119_054407_insert_hire_lesa_field cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191119_054407_insert_hire_lesa_field cannot be reverted.\n";

        return false;
    }
    */
}
