<?php

use yii\db\Migration;

/**
 * Class m190711_060226_fix_Equipments
 */
class m190711_060226_fix_Equipments extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("ALTER TABLE `equipments` 
ADD CONSTRAINT `fk_equipments_3`
  FOREIGN KEY (`status`)
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
        echo "m190711_060226_fix_Equipments cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190711_060226_fix_Equipments cannot be reverted.\n";

        return false;
    }
    */
}
