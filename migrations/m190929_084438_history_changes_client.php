<?php

use yii\db\Migration;

/**
 * Class m190929_084438_history_changes_client
 */
class m190929_084438_history_changes_client extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("ALTER TABLE `equipments_history` 
ADD COLUMN `user_id` INT(11) NOT NULL AFTER `date_create`,
ADD INDEX `fk_equipments_history_3_idx` (`user_id` ASC);
ALTER TABLE `equipments_history` 
ADD CONSTRAINT `fk_equipments_history_3`
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
        echo "m190929_084438_history_changes_client cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190929_084438_history_changes_client cannot be reverted.\n";

        return false;
    }
    */
}
