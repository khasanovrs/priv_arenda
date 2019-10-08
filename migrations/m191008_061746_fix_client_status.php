<?php

use yii\db\Migration;

/**
 * Class m191008_061746_fix_client_status
 */
class m191008_061746_fix_client_status extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("UPDATE `applications_status` SET `name`='Отказ' WHERE `id`='4';");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m191008_061746_fix_client_status cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191008_061746_fix_client_status cannot be reverted.\n";

        return false;
    }
    */
}
