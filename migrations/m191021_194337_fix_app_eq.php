<?php

use yii\db\Migration;

/**
 * Class m191021_194337_fix_app_eq
 */
class m191021_194337_fix_app_eq extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("ALTER TABLE `application_equipment` 
ADD COLUMN `delivery_sum_paid` VARCHAR(45) NOT NULL DEFAULT '0' AFTER `delivery_sum`;
");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m191021_194337_fix_app_eq cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191021_194337_fix_app_eq cannot be reverted.\n";

        return false;
    }
    */
}
