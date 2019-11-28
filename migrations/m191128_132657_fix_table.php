<?php

use yii\db\Migration;

/**
 * Class m191128_132657_fix_table
 */
class m191128_132657_fix_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("INSERT INTO `equipments_demand_field` (`id`, `code`, `name`) VALUES ('1', 'name', 'Наименование');");
        $this->execute("INSERT INTO `equipments_demand_field` (`id`, `code`, `name`) VALUES ('2', 'stock', 'Склад');");

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m191128_132657_fix_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191128_132657_fix_table cannot be reverted.\n";

        return false;
    }
    */
}
