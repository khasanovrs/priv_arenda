<?php

use yii\db\Migration;

/**
 * Class m191010_131228_fix_finance
 */
class m191010_131228_fix_finance extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("ALTER TABLE `finance` 
DROP FOREIGN KEY `fk_finance_1`;
ALTER TABLE `finance` 
CHANGE COLUMN `branch_id` `branch_id` INT(11) NULL ,
ADD COLUMN `eq_id` INT(11) NULL COMMENT 'идентификатор оборудования' AFTER `cashBox_id`;
ALTER TABLE `finance` 
ADD CONSTRAINT `fk_finance_1`
  FOREIGN KEY (`branch_id`)
  REFERENCES `branch` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;
");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m191010_131228_fix_finance cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191010_131228_fix_finance cannot be reverted.\n";

        return false;
    }
    */
}
