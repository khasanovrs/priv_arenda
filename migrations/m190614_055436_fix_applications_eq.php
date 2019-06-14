<?php

use yii\db\Migration;

/**
 * Class m190614_055436_fix_applications_eq
 */
class m190614_055436_fix_applications_eq extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("ALTER TABLE `application_equipment` 
        ADD COLUMN `status_id` INT(11) NOT NULL AFTER `id`,
        ADD INDEX `fk_application_equipment_3_idx` (`status_id` ASC);
        ALTER TABLE `application_equipment` 
        ADD CONSTRAINT `fk_application_equipment_3`
          FOREIGN KEY (`status_id`)
          REFERENCES `applications_status` (`id`)
          ON DELETE NO ACTION
          ON UPDATE NO ACTION;
        ");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190614_055436_fix_applications_eq cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190614_055436_fix_applications_eq cannot be reverted.\n";

        return false;
    }
    */
}
