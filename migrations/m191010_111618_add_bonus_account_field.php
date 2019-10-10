<?php

use yii\db\Migration;

/**
 * Class m191010_111618_add_bonus_account_field
 */
class m191010_111618_add_bonus_account_field extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("INSERT INTO `client_field` (`id`, `code`, `name`) VALUES ('14', 'bonus_account', 'Бонусный счет');");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m191010_111618_add_bonus_account_field cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191010_111618_add_bonus_account_field cannot be reverted.\n";

        return false;
    }
    */
}
