<?php

use yii\db\Migration;

/**
 * Class m191013_074900_fix_app_eq
 */
class m191013_074900_fix_app_eq extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
$this->execute("ALTER TABLE `application_equipment` 
ADD CONSTRAINT `hireState`
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
        echo "m191013_074900_fix_app_eq cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191013_074900_fix_app_eq cannot be reverted.\n";

        return false;
    }
    */
}
