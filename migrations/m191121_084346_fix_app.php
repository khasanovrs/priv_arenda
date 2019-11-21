<?php

use yii\db\Migration;

/**
 * Class m191121_084346_fix_app
 */
class m191121_084346_fix_app extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("ALTER TABLE `applications` 
ADD COLUMN `delivery_sum` VARCHAR(45) CHARACTER SET 'utf8' NOT NULL DEFAULT '0' COMMENT 'сумма доставки' AFTER `address`,
ADD COLUMN `delivery_sum_paid` VARCHAR(45) CHARACTER SET 'utf8' NOT NULL DEFAULT '0' COMMENT 'сумма оплаты доставки' AFTER `delivery_sum`,
ADD COLUMN `sum` VARCHAR(45) CHARACTER SET 'utf8' NOT NULL COMMENT 'сумма' AFTER `delivery_sum_paid`,
ADD COLUMN `sum_sale` VARCHAR(45) CHARACTER SET 'utf8' NOT NULL DEFAULT '0' COMMENT 'сумма со скидкой' AFTER `sum`,
ADD COLUMN `total_paid` VARCHAR(45) CHARACTER SET 'utf8' NOT NULL DEFAULT '0' COMMENT 'оплочено за прокат' AFTER `sum_sale`;
");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m191121_084346_fix_app cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191121_084346_fix_app cannot be reverted.\n";

        return false;
    }
    */
}
