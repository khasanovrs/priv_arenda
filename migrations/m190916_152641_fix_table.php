<?php

use yii\db\Migration;

/**
 * Class m190916_152641_fix_table
 */
class m190916_152641_fix_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
$this->execute("ALTER TABLE `extension` ADD COLUMN `type` VARCHAR(45) NOT NULL COMMENT 'тип продления, 1- день, 2-месяц' AFTER `application_equipment_id`;");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190916_152641_fix_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190916_152641_fix_table cannot be reverted.\n";

        return false;
    }
    */
}
