<?php

use yii\db\Migration;

/**
 * Class m191128_134935_fix_table
 */
class m191128_134935_fix_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("ALTER TABLE `equipments_demand` ADD COLUMN `count_demand` INT(11) NOT NULL DEFAULT 0 COMMENT 'Количество запросов' AFTER `stock_id`;");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m191128_134935_fix_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191128_134935_fix_table cannot be reverted.\n";

        return false;
    }
    */
}
