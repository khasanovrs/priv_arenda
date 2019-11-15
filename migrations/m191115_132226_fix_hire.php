<?php

use yii\db\Migration;

/**
 * Class m191115_132226_fix_hire
 */
class m191115_132226_fix_hire extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("ALTER TABLE `equipments` 
ADD COLUMN `count_hire` VARCHAR(45) NOT NULL DEFAULT 0 AFTER `confirmed`,
ADD COLUMN `count_repairs` VARCHAR(45) NOT NULL DEFAULT 0 AFTER `count_hire`;");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m191115_132226_fix_hire cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191115_132226_fix_hire cannot be reverted.\n";

        return false;
    }
    */
}
