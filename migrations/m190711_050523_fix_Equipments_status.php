<?php

use yii\db\Migration;

/**
 * Class m190711_050523_fix_Equipments_status
 */
class m190711_050523_fix_Equipments_status extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("ALTER TABLE `equipments_status` ADD COLUMN `color` VARCHAR(45) NOT NULL DEFAULT '#000000' AFTER `name`;");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190711_050523_fix_Equipments_status cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190711_050523_fix_Equipments_status cannot be reverted.\n";

        return false;
    }
    */
}
