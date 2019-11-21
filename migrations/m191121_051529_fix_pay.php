<?php

use yii\db\Migration;

/**
 * Class m191121_051529_fix_pay
 */
class m191121_051529_fix_pay extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("ALTER TABLE `application_pay` 
ADD COLUMN `group_pay` VARCHAR(45) NOT NULL COMMENT 'группировка платежей для лесов' AFTER `client_id`;
");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m191121_051529_fix_pay cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191121_051529_fix_pay cannot be reverted.\n";

        return false;
    }
    */
}
