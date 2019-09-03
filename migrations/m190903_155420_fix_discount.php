<?php

use yii\db\Migration;

/**
 * Class m190903_155420_fix_discount
 */
class m190903_155420_fix_discount extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("UPDATE `discount` SET `code` = '0', `name` = '0%' WHERE (`id` = '1');");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190903_155420_fix_discount cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190903_155420_fix_discount cannot be reverted.\n";

        return false;
    }
    */
}
