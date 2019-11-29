<?php

use yii\db\Migration;

/**
 * Class m191129_065505_fix_table
 */
class m191129_065505_fix_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("ALTER TABLE `applications_demand` 
CHANGE COLUMN `eq_id` `eq_id` INT(11) NOT NULL ,
ADD INDEX `fk_applications_demand_1_idx` (`eq_id` ASC);
ALTER TABLE `applications_demand` 
ADD CONSTRAINT `fk_applications_demand_1`
  FOREIGN KEY (`eq_id`)
  REFERENCES `equipments_demand` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;
");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m191129_065505_fix_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191129_065505_fix_table cannot be reverted.\n";

        return false;
    }
    */
}
