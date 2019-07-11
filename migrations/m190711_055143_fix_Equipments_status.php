<?php

use yii\db\Migration;

/**
 * Class m190711_055143_fix_Equipments_status
 */
class m190711_055143_fix_Equipments_status extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("ALTER TABLE `equipments_status` CHANGE COLUMN `id` `id` INT(11) NOT NULL AUTO_INCREMENT ;");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190711_055143_fix_Equipments_status cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190711_055143_fix_Equipments_status cannot be reverted.\n";

        return false;
    }
    */
}
