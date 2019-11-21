<?php

use yii\db\Migration;

/**
 * Class m191121_103923_fix_table
 */
class m191121_103923_fix_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("CREATE TABLE `application_sum_delivery` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `application_id` INT(11) NOT NULL,
  `delivery_sum` VARCHAR(45) NOT NULL DEFAULT '0' COMMENT 'сумма доставки',
  `delivery_sum_paid` VARCHAR(45) NOT NULL DEFAULT '0' COMMENT 'сумма оплаты доставки',
  PRIMARY KEY (`id`),
  INDEX `fk_application_sum_hire_1_idx` (`application_id` ASC),
  CONSTRAINT `fk_application_sum_hire_1`
    FOREIGN KEY (`application_id`)
    REFERENCES `applications` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION);
");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m191121_103923_fix_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191121_103923_fix_table cannot be reverted.\n";

        return false;
    }
    */
}
