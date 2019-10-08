<?php

use yii\db\Migration;

/**
 * Class m191008_101238_fix_client
 */
class m191008_101238_fix_client extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("DELETE FROM `client_field` WHERE `id`='10';");
        $this->execute("DELETE FROM `client_field` WHERE `id`='9';");

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m191008_101238_fix_client cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191008_101238_fix_client cannot be reverted.\n";

        return false;
    }
    */
}
