<?php

use yii\db\Migration;

/**
 * Class m191121_123858_fix_table
 */
class m191121_123858_fix_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("ALTER TABLE `application_equipment` 
DROP FOREIGN KEY `fk_application_equipment_6`;
ALTER TABLE `application_equipment` 
DROP COLUMN `hire_status_id`,
DROP INDEX `fk_application_equipment_5_idx1` ;
");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m191121_123858_fix_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191121_123858_fix_table cannot be reverted.\n";

        return false;
    }
    */
}
