<?php

use yii\db\Migration;

/**
 * Class m190711_062908_fix_source_client
 */
class m190711_062908_fix_source_client extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
$this->execute("DROP TABLE `client_source`;");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190711_062908_fix_source_client cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190711_062908_fix_source_client cannot be reverted.\n";

        return false;
    }
    */
}
