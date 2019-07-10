<?php

use yii\db\Migration;

/**
 * Class m190710_074441_fix_finance
 */
class m190710_074441_fix_finance extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("ALTER TABLE `finance` 
        ADD COLUMN `branch_id` INT(11) NOT NULL AFTER `name`,
        ADD INDEX `fk_finance_1_idx` (`branch_id` ASC);
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
        echo "m190710_074441_fix_finance cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190710_074441_fix_finance cannot be reverted.\n";

        return false;
    }
    */
}
