<?php

use yii\db\Migration;

/**
 * Class m191124_181932_fix_table
 */
class m191124_181932_fix_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
$this->execute("ALTER TABLE `applications` 
ADD CONSTRAINT `fk_applications_8`
  FOREIGN KEY (`equipments_status`)
  REFERENCES `equipments_status` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;
");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m191124_181932_fix_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191124_181932_fix_table cannot be reverted.\n";

        return false;
    }
    */
}
