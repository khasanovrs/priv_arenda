<?php

use yii\db\Migration;

/**
 * Class m191012_060117_add_bonus_account
 */
class m191012_060117_add_bonus_account extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("INSERT INTO `settings` (`id`, `code`, `name`, `value`) VALUES ('1', 'bonus_account', 'Бонусный счет', '3');");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m191012_060117_add_bonus_account cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191012_060117_add_bonus_account cannot be reverted.\n";

        return false;
    }
    */
}
