<?php

use yii\db\Migration;

/**
 * Class m191129_101958_fix_table
 */
class m191129_101958_fix_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("UPDATE `equipments_demand_field` SET `name`='Оборудование' WHERE `id`='1';
INSERT INTO `equipments_demand_field` (`id`, `code`, `name`) VALUES ('4', 'user', 'Пользователь');
INSERT INTO `equipments_demand_field` (`id`, `code`, `name`) VALUES ('5', 'client', 'Клиент');
INSERT INTO `equipments_demand_field` (`id`, `code`, `name`) VALUES ('6', 'coment', 'Комментарий');
INSERT INTO `equipments_demand_field` (`id`, `code`, `name`) VALUES ('7', 'date_create', 'Дата создания');
");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m191129_101958_fix_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191129_101958_fix_table cannot be reverted.\n";

        return false;
    }
    */
}
