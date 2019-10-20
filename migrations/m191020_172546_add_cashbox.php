<?php

use yii\db\Migration;

/**
 * Class m191020_172546_add_cashbox
 */
class m191020_172546_add_cashbox extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
$this->execute("ALTER TABLE `finance_cashbox` 
ADD COLUMN `delivery` VARCHAR(45) NOT NULL AFTER `check_zalog`;
");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m191020_172546_add_cashbox cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191020_172546_add_cashbox cannot be reverted.\n";

        return false;
    }
    */
}
