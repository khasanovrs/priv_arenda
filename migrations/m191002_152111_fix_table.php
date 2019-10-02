<?php

use yii\db\Migration;

/**
 * Class m191002_152111_fix_table
 */
class m191002_152111_fix_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
$this->execute("ALTER TABLE `equipments_history_change_status` 
DROP FOREIGN KEY `fk_equipments_history_change_status_3`;
ALTER TABLE `equipments_history_change_status` 
ADD INDEX `fk_equipments_history_change_status_3_idx` (`new_status` ASC) VISIBLE,
DROP INDEX `fk_equipments_history_change_status_3_idx` ;
;
ALTER TABLE `equipments_history_change_status` 
ADD CONSTRAINT `fk_equipments_history_change_status_3`
  FOREIGN KEY (`new_status`)
  REFERENCES `equipments_status` (`id`);
");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m191002_152111_fix_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191002_152111_fix_table cannot be reverted.\n";

        return false;
    }
    */
}
