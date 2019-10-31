<?php

use yii\db\Migration;

/**
 * Class m191031_044300_fix_cashbox
 */
class m191031_044300_fix_cashbox extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("UPDATE `finance_cashbox` SET `delivery`='0' WHERE `id`='1';");
        $this->execute("UPDATE `finance_cashbox` SET `delivery`='0' WHERE `id`='2';");
        $this->execute("UPDATE `finance_cashbox` SET `delivery`='0' WHERE `id`='3';");
        $this->execute("UPDATE `finance_cashbox` SET `delivery`='0' WHERE `id`='4';");
        $this->execute("UPDATE `finance_cashbox` SET `delivery`='0' WHERE `id`='5';");
        $this->execute("UPDATE `finance_cashbox` SET `delivery`='0' WHERE `id`='6';");
        $this->execute("UPDATE `finance_cashbox` SET `delivery`='0' WHERE `id`='7';");
        $this->execute("UPDATE `finance_cashbox` SET `delivery`='0' WHERE `id`='8';");
        $this->execute("UPDATE `finance_cashbox` SET `delivery`='0' WHERE `id`='9';");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m191031_044300_fix_cashbox cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191031_044300_fix_cashbox cannot be reverted.\n";

        return false;
    }
    */
}
