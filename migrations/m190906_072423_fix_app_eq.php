<?php

use yii\db\Migration;

/**
 * Class m190906_072423_fix_app_eq
 */
class m190906_072423_fix_app_eq extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("ALTER TABLE `application_equipment` 
ADD COLUMN `hire_state_id` VARCHAR(45) NULL AFTER `hire_status_id`;
ALTER TABLE `application_equipment` 
ADD CONSTRAINT `fk_application_equipment_5`
  FOREIGN KEY ()
  REFERENCES `hire_state` ()
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;
");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190906_072423_fix_app_eq cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190906_072423_fix_app_eq cannot be reverted.\n";

        return false;
    }
    */
}
