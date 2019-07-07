<?php

use yii\db\Migration;

/**
 * Class m190707_060127_sum_finance_cachebox
 */
class m190707_060127_sum_finance_cachebox extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("ALTER TABLE `finance_cashbox` 
            ADD COLUMN `sum` VARCHAR(45) NOT NULL DEFAULT 0 AFTER `name`;
        ");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190707_060127_sum_finance_cachebox cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190707_060127_sum_finance_cachebox cannot be reverted.\n";

        return false;
    }
    */
}
