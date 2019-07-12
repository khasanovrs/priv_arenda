<?php

use yii\db\Migration;

/**
 * Class m190712_100823_applications_fix
 */
class m190712_100823_applications_fix extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("ALTER TABLE `application_equipment` 
ADD COLUMN `hire_status_id` INT(11) NOT NULL DEFAULT 1 AFTER `status_id`,
ADD INDEX `fk_application_equipment_4_idx` (`hire_status_id` ASC);
ALTER TABLE `application_equipment` 
ADD CONSTRAINT `fk_application_equipment_4`
  FOREIGN KEY (`hire_status_id`)
  REFERENCES `hire_status` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;
");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190712_100823_applications_fix cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190712_100823_applications_fix cannot be reverted.\n";

        return false;
    }
    */
}
