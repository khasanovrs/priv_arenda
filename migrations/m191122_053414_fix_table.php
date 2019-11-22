<?php

use yii\db\Migration;

/**
 * Class m191122_053414_fix_table
 */
class m191122_053414_fix_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("ALTER TABLE `applications` 
ADD COLUMN `sum` VARCHAR(45) NOT NULL COMMENT 'сумма' AFTER `delivery_sum_id`,
ADD COLUMN `sum_sale` VARCHAR(45) NOT NULL DEFAULT '0' COMMENT 'сумма со скидкой' AFTER `sum`,
ADD COLUMN `total_paid` VARCHAR(45) NOT NULL DEFAULT '0' COMMENT 'оплочено за прокат' AFTER `sum_sale`;
");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m191122_053414_fix_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191122_053414_fix_table cannot be reverted.\n";

        return false;
    }
    */
}
