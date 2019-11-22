<?php

use yii\db\Migration;

/**
 * Class m191122_075941_fix_table
 */
class m191122_075941_fix_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("ALTER TABLE `extension` 
CHANGE COLUMN `application_equipment_id` `application_id` INT(11) NOT NULL ;
ALTER TABLE `extension` 
ADD CONSTRAINT `fk_extension_1`
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
        echo "m191122_075941_fix_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191122_075941_fix_table cannot be reverted.\n";

        return false;
    }
    */
}
