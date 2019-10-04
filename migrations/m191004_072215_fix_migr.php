<?php

use yii\db\Migration;

/**
 * Class m191004_072215_fix_migr
 */
class m191004_072215_fix_migr extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("ALTER TABLE `equipments_history_change_status` 
ADD CONSTRAINT `fk_equipments_history_change_status_3`
  FOREIGN KEY (`new_status`)
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
        echo "m191004_072215_fix_migr cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191004_072215_fix_migr cannot be reverted.\n";

        return false;
    }
    */
}
