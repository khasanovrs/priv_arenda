<?php

use yii\db\Migration;

/**
 * Class m191024_120921_fix_branch
 */
class m191024_120921_fix_branch extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
$this->execute("ALTER TABLE `branch` 
ADD COLUMN `time_diff` VARCHAR(45) NOT NULL DEFAULT 0 COMMENT 'Разница с московским временем' AFTER `region`;
");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m191024_120921_fix_branch cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191024_120921_fix_branch cannot be reverted.\n";

        return false;
    }
    */
}
