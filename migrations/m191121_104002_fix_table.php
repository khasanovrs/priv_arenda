<?php

use yii\db\Migration;

/**
 * Class m191121_104002_fix_table
 */
class m191121_104002_fix_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("ALTER TABLE `application_sum` 
DROP COLUMN `delivery_sum_paid`,
DROP COLUMN `delivery_sum`;
");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m191121_104002_fix_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191121_104002_fix_table cannot be reverted.\n";

        return false;
    }
    */
}
