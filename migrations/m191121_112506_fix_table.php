<?php

use yii\db\Migration;

/**
 * Class m191121_112506_fix_table
 */
class m191121_112506_fix_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("INSERT INTO `application_sum_delivery` (`id`, `delivery_sum`, `delivery_sum_paid`) VALUES ('1', '0', '0');");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m191121_112506_fix_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191121_112506_fix_table cannot be reverted.\n";

        return false;
    }
    */
}
