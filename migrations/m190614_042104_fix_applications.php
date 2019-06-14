<?php

use yii\db\Migration;

/**
 * Class m190614_042104_fix_applications
 */
class m190614_042104_fix_applications extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("ALTER TABLE `applications` 
ADD COLUMN `user_id` INT(11) NOT NULL AFTER `type_lease_id`,
ADD INDEX `fk_applications_2_idx` (`user_id` ASC);
ALTER TABLE `applications` 
ADD CONSTRAINT `fk_applications_2`
  FOREIGN KEY (`user_id`)
  REFERENCES `users` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;
");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190614_042104_fix_applications cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190614_042104_fix_applications cannot be reverted.\n";

        return false;
    }
    */
}
