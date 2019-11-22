<?php

use yii\db\Migration;

/**
 * Class m191122_055136_fix_table
 */
class m191122_055136_fix_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("ALTER TABLE `application_equipment` 
DROP FOREIGN KEY `fk_application_equipment_5`,
DROP FOREIGN KEY `fk_application_equipment_3`;
ALTER TABLE `application_equipment` 
DROP COLUMN `hire_state_id`,
DROP COLUMN `status_id`,
DROP INDEX `fk_application_equipment_5_idx` ,
DROP INDEX `fk_application_equipment_3_idx` ;
");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m191122_055136_fix_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191122_055136_fix_table cannot be reverted.\n";

        return false;
    }
    */
}
