<?php

use yii\db\Migration;

/**
 * Class m191129_102756_fix_table
 */
class m191129_102756_fix_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("ALTER TABLE `applications_demand` 
ADD INDEX `fk_applications_demand_2_idx` (`branch_id` ASC),
ADD INDEX `fk_applications_demand_3_idx` (`user_id` ASC),
ADD INDEX `fk_applications_demand_4_idx` (`client_id` ASC);
ALTER TABLE `applications_demand` 
ADD CONSTRAINT `fk_applications_demand_2`
  FOREIGN KEY (`branch_id`)
  REFERENCES `branch` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_applications_demand_3`
  FOREIGN KEY (`user_id`)
  REFERENCES `users` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_applications_demand_4`
  FOREIGN KEY (`client_id`)
  REFERENCES `clients` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;

");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m191129_102756_fix_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191129_102756_fix_table cannot be reverted.\n";

        return false;
    }
    */
}
