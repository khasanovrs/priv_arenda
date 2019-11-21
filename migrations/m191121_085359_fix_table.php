<?php

use yii\db\Migration;

/**
 * Class m191121_085359_fix_table
 */
class m191121_085359_fix_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("CREATE TABLE `application_sum` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `application_id` INT(11) NULL,
  `delivery_sum` VARCHAR(45) CHARACTER SET 'utf8' NOT NULL DEFAULT '0' COMMENT 'сумма доставки',
  `delivery_sum_paid` VARCHAR(45) CHARACTER SET 'utf8' NOT NULL DEFAULT '0' COMMENT 'сумма оплаты доставки',
  `sum` VARCHAR(45) CHARACTER SET 'utf8' NOT NULL COMMENT 'сумма',
  `sum_sale` VARCHAR(45) CHARACTER SET 'utf8' NOT NULL DEFAULT '0' COMMENT 'сумма со скидкой',
  `total_paid` VARCHAR(45) CHARACTER SET 'utf8' NOT NULL DEFAULT '0' COMMENT 'оплочено за прокат',
  PRIMARY KEY (`id`));
");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m191121_085359_fix_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191121_085359_fix_table cannot be reverted.\n";

        return false;
    }
    */
}
