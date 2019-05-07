<?php

use yii\db\Migration;

/**
 * Class m190507_072836_insert_user_role
 */
class m190507_072836_insert_user_role extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("INSERT INTO `users_role` (`id`, `name`) VALUES ('1', 'Администратор');");
        $this->execute("INSERT INTO `users_role` (`id`, `name`) VALUES ('2', 'Менеджер');");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190507_072836_insert_user_role cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190507_072836_insert_user_role cannot be reverted.\n";

        return false;
    }
    */
}
