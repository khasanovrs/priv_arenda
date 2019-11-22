<?php

use yii\db\Migration;

/**
 * Class m191122_053418_fix_table
 */
class m191122_053418_fix_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("DROP TABLE `application_sum`;");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m191122_053418_fix_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191122_053418_fix_table cannot be reverted.\n";

        return false;
    }
    */
}
