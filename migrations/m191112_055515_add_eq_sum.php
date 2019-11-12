<?php

use yii\db\Migration;

/**
 * Class m191112_055515_add_eq_sum
 */
class m191112_055515_add_eq_sum extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("ALTER TABLE `equipments` 
ADD COLUMN `selling` VARCHAR(45) NULL COMMENT 'стоимость оборудования' AFTER `count`;
");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m191112_055515_add_eq_sum cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191112_055515_add_eq_sum cannot be reverted.\n";

        return false;
    }
    */
}
