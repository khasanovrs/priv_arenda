<?php

use yii\db\Migration;

/**
 * Class m190929_084039_history_changes_client
 */
class m190929_084039_history_changes_client extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("ALTER TABLE `equipments_history` 
ADD INDEX `fk_equipments_history_1_idx` (`equipments_id` ASC),
ADD INDEX `fk_equipments_history_2_idx` (`type_change` ASC);
ALTER TABLE `equipments_history` 
ADD CONSTRAINT `fk_equipments_history_1`
  FOREIGN KEY (`equipments_id`)
  REFERENCES `equipments` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_equipments_history_2`
  FOREIGN KEY (`type_change`)
  REFERENCES `type_changes` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;
");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190929_084039_history_changes_client cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190929_084039_history_changes_client cannot be reverted.\n";

        return false;
    }
    */
}
