<?php

use yii\db\Migration;

/**
 * Class m191121_085638_fix_table
 */
class m191121_085638_fix_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("ALTER TABLE `application_sum` 
CHANGE COLUMN `application_id` `application_id` INT(11) NOT NULL ,
ADD INDEX `fk_application_sum_1_idx` (`application_id` ASC);
ALTER TABLE `application_sum` 
ADD CONSTRAINT `fk_application_sum_1`
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
        echo "m191121_085638_fix_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191121_085638_fix_table cannot be reverted.\n";

        return false;
    }
    */
}
