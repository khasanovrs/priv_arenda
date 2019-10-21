<?php

use yii\db\Migration;

/**
 * Class m191021_195537_fix_app_eq
 */
class m191021_195537_fix_app_eq extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
$this->execute("ALTER TABLE `application_equipment` 
ADD CONSTRAINT `fk_application_equipment_6`
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
        echo "m191021_195537_fix_app_eq cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191021_195537_fix_app_eq cannot be reverted.\n";

        return false;
    }
    */
}
