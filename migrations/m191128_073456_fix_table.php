<?php

use yii\db\Migration;

/**
 * Class m191128_073456_fix_table
 */
class m191128_073456_fix_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("ALTER TABLE `applications` ADD COLUMN `num_dog` VARCHAR(45) NOT NULL COMMENT 'Номер договора' AFTER `equipments_status`;");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m191128_073456_fix_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191128_073456_fix_table cannot be reverted.\n";

        return false;
    }
    */
}
