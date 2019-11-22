<?php

use yii\db\Migration;

/**
 * Class m191122_055134_fix_table
 */
class m191122_055134_fix_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("ALTER TABLE `applications` 
ADD COLUMN `status_id` INT(11) NOT NULL AFTER `total_paid`,
ADD COLUMN `hire_state_id` INT(11) NOT NULL AFTER `status_id`,
ADD INDEX `fk_applications_6_idx` (`status_id` ASC),
ADD INDEX `fk_applications_7_idx` (`hire_state_id` ASC);
ALTER TABLE `applications` 
ADD CONSTRAINT `fk_applications_6`
  FOREIGN KEY (`status_id`)
  REFERENCES `applications_status` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_applications_7`
  FOREIGN KEY (`hire_state_id`)
  REFERENCES `hire_state` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;
");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m191122_055134_fix_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191122_055134_fix_table cannot be reverted.\n";

        return false;
    }
    */
}
