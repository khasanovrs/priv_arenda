<?php

use yii\db\Migration;

/**
 * Class m190613_151104_fix_applications
 */
class m190613_151104_fix_applications extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("ALTER TABLE `applications` 
            DROP FOREIGN KEY `a2`;
            ALTER TABLE `applications` 
            DROP COLUMN `equipments_count`,
            DROP COLUMN `equipments_id`,
            DROP INDEX `a2_idx` ;
            ");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190613_151104_fix_applications cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190613_151104_fix_applications cannot be reverted.\n";

        return false;
    }
    */
}
