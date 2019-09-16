<?php

use yii\db\Migration;

/**
 * Class m190916_120410_fix_table
 */
class m190916_120410_fix_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("ALTER TABLE `equipments_info` ADD COLUMN `comment` VARCHAR(500) NULL AFTER `frequency_hits`;");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190916_120410_fix_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190916_120410_fix_table cannot be reverted.\n";

        return false;
    }
    */
}
