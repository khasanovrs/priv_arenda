<?php

use yii\db\Migration;

/**
 * Class m191008_073243_fix_eq
 */
class m191008_073243_fix_eq extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("ALTER TABLE `equipments` 
DROP FOREIGN KEY `fk_equipments_3`;
ALTER TABLE `equipments` 
CHANGE COLUMN `status` `status` INT(11) NOT NULL COMMENT 'Доступность' ;
ALTER TABLE `equipments` 
ADD CONSTRAINT `fk_equipments_3`
  FOREIGN KEY (`status`)
  REFERENCES `equipments_status` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;
");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m191008_073243_fix_eq cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191008_073243_fix_eq cannot be reverted.\n";

        return false;
    }
    */
}
