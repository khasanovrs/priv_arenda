<?php

use yii\db\Migration;

/**
 * Class m191003_111407_fix_date_birth
 */
class m191003_111407_fix_date_birth extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("ALTER TABLE `clients_info` ADD COLUMN `date_birth` VARCHAR(150) NULL AFTER `phone_second`;");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m191003_111407_fix_date_birth cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191003_111407_fix_date_birth cannot be reverted.\n";

        return false;
    }
    */
}
