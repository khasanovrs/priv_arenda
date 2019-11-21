<?php

use yii\db\Migration;

/**
 * Class m191121_123922_fix_table
 */
class m191121_123922_fix_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("DROP TABLE `hire_status`;");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m191121_123922_fix_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191121_123922_fix_table cannot be reverted.\n";

        return false;
    }
    */
}
