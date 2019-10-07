<?php

use yii\db\Migration;

/**
 * Class m191006_175145_fix_cashe_box
 */
class m191006_175145_fix_cashe_box extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("ALTER TABLE `finance_cashbox` 
ADD COLUMN `check_zalog` VARCHAR(45) NOT NULL DEFAULT 0 COMMENT 'Залог касса. 0-нет,1-да' AFTER `sum`;
");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m191006_175145_fix_cashe_box cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191006_175145_fix_cashe_box cannot be reverted.\n";

        return false;
    }
    */
}
