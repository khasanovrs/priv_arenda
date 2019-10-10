<?php

use yii\db\Migration;

/**
 * Class m191010_111222_add_bonus_account
 */
class m191010_111222_add_bonus_account extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
$this->execute("ALTER TABLE `clients_info` ADD COLUMN `bonus_account` VARCHAR(45) NOT NULL DEFAULT 0 AFTER `date_update`;");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m191010_111222_add_bonus_account cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191010_111222_add_bonus_account cannot be reverted.\n";

        return false;
    }
    */
}
