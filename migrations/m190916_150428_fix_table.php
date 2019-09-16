<?php

use yii\db\Migration;

/**
 * Class m190916_150428_fix_table
 */
class m190916_150428_fix_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("ALTER TABLE `extension` 
ADD COLUMN `application_equipment_id` INT(11) NOT NULL AFTER `user_id`,
ADD INDEX `rty_2_idx` (`application_equipment_id` ASC) VISIBLE;
;
ALTER TABLE `extension` 
ADD CONSTRAINT `rty_2`
  FOREIGN KEY (`application_equipment_id`)
  REFERENCES `application_equipment` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;
");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190916_150428_fix_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190916_150428_fix_table cannot be reverted.\n";

        return false;
    }
    */
}
