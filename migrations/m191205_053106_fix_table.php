<?php

use yii\db\Migration;

/**
 * Class m191205_053106_fix_table
 */
class m191205_053106_fix_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("ALTER TABLE `equipments` DROP COLUMN `confirmed`;");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m191205_053106_fix_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191205_053106_fix_table cannot be reverted.\n";

        return false;
    }
    */
}
