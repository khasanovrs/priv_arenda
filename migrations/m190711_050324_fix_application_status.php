<?php

use yii\db\Migration;

/**
 * Class m190711_050324_fix_application_status
 */
class m190711_050324_fix_application_status extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("ALTER TABLE `applications_status` ADD COLUMN `color` VARCHAR(45) NOT NULL DEFAULT '#ffffff' AFTER `name`;");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190711_050324_fix_application_status cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190711_050324_fix_application_status cannot be reverted.\n";

        return false;
    }
    */
}
