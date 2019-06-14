<?php

use yii\db\Migration;

/**
 * Class m190614_055406_fix_applications
 */
class m190614_055406_fix_applications extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("ALTER TABLE `applications` 
        DROP FOREIGN KEY `a4`;
        ALTER TABLE `applications` 
        DROP COLUMN `status_id`,
        DROP INDEX `a4_idx` ;
        ");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190614_055406_fix_applications cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190614_055406_fix_applications cannot be reverted.\n";

        return false;
    }
    */
}
