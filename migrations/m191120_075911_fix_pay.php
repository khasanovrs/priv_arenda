<?php

use yii\db\Migration;

/**
 * Class m191120_075911_fix_pay
 */
class m191120_075911_fix_pay extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("ALTER TABLE `application_pay` 
ADD COLUMN `application_id` INT(11) NOT NULL AFTER `application_equipment_id`,
ADD INDEX `fk_application_pay_4_idx` (`application_id` ASC);
ALTER TABLE `application_pay` 
ADD CONSTRAINT `fk_application_pay_4`
  FOREIGN KEY (`application_id`)
  REFERENCES `applications` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;
");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m191120_075911_fix_pay cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191120_075911_fix_pay cannot be reverted.\n";

        return false;
    }
    */
}
