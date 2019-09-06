<?php

use yii\db\Migration;

/**
 * Class m190906_074256_fix_pr_key
 */
class m190906_074256_fix_pr_key extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("ALTER TABLE `application_equipment` 
ADD INDEX `fk_application_equipment_5_idx` (`hire_state_id` ASC);
ALTER TABLE `application_equipment` 
ADD CONSTRAINT `fk_application_equipment_5`
  FOREIGN KEY (`hire_state_id`)
  REFERENCES `hire_state` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;
");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190906_074256_fix_pr_key cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190906_074256_fix_pr_key cannot be reverted.\n";

        return false;
    }
    */
}
