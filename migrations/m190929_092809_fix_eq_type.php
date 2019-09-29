<?php

use yii\db\Migration;

/**
 * Class m190929_092809_fix_eq_type
 */
class m190929_092809_fix_eq_type extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("ALTER TABLE `equipments_type` 
ADD COLUMN `category_id` INT(11) NOT NULL AFTER `id`,
ADD INDEX `fk_equipments_type_1_idx` (`category_id` ASC);
ALTER TABLE `equipments_type` 
ADD CONSTRAINT `fk_equipments_type_1`
  FOREIGN KEY (`category_id`)
  REFERENCES `equipments_category` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;
");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190929_092809_fix_eq_type cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190929_092809_fix_eq_type cannot be reverted.\n";

        return false;
    }
    */
}
