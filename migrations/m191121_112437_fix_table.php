<?php

use yii\db\Migration;

/**
 * Class m191121_112437_fix_table
 */
class m191121_112437_fix_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("ALTER TABLE `applications` 
ADD COLUMN `delivery_sum_id` INT(11) NOT NULL AFTER `address`,
ADD INDEX `fk_applications_5_idx` (`delivery_sum_id` ASC);
ALTER TABLE `applications` 
ADD CONSTRAINT `fk_applications_5`
  FOREIGN KEY (`delivery_sum_id`)
  REFERENCES `application_sum_delivery` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;
");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m191121_112437_fix_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191121_112437_fix_table cannot be reverted.\n";

        return false;
    }
    */
}
