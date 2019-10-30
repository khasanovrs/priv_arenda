<?php

use yii\db\Migration;

/**
 * Class m191030_184245_fix_cashbox
 */
class m191030_184245_fix_cashbox extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("UPDATE `finance_cashbox` SET `check_zalog` = '1' WHERE (`id` = '6');");
        $this->execute("UPDATE `finance_cashbox` SET `check_zalog` = '1' WHERE (`id` = '7');");
        $this->execute("UPDATE `finance_cashbox` SET `check_zalog` = '1' WHERE (`id` = '8');");
        $this->execute("UPDATE `finance_cashbox` SET `check_zalog` = '1' WHERE (`id` = '9');");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m191030_184245_fix_cashbox cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191030_184245_fix_cashbox cannot be reverted.\n";

        return false;
    }
    */
}
