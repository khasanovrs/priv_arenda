<?php

use yii\db\Migration;

/**
 * Class m190927_080952_fix_change_client_status
 */
class m190927_080952_fix_change_client_status extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("ALTER TABLE `client_status_change` 
ADD COLUMN `user_id` INT(11) NOT NULL AFTER `new_status`,
ADD INDEX `fk_client_status_change_4_idx` (`user_id` ASC);
ALTER TABLE `client_status_change` 
ADD CONSTRAINT `fk_client_status_change_4`
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
        echo "m190927_080952_fix_change_client_status cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190927_080952_fix_change_client_status cannot be reverted.\n";

        return false;
    }
    */
}
