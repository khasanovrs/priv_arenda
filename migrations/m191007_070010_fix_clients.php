<?php

use yii\db\Migration;

/**
 * Class m191007_070010_fix_clients
 */
class m191007_070010_fix_clients extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("ALTER TABLE `clients` 
ADD COLUMN `is_not_active` VARCHAR(45) NOT NULL DEFAULT 0 COMMENT '0-активный,1-не активный' AFTER `date_create`;
");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m191007_070010_fix_clients cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191007_070010_fix_clients cannot be reverted.\n";

        return false;
    }
    */
}
