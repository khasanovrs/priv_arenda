<?php

use yii\db\Migration;

/**
 * Class m191031_044500_fix_cashbox
 */
class m191031_044500_fix_cashbox extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("ALTER TABLE `finance_cashbox` 
CHANGE COLUMN `delivery` `delivery` VARCHAR(45) CHARACTER SET 'utf8' NOT NULL DEFAULT 0 ;
");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m191031_044500_fix_cashbox cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191031_044500_fix_cashbox cannot be reverted.\n";

        return false;
    }
    */
}
