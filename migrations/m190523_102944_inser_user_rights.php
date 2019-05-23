<?php

use yii\db\Migration;

/**
 * Class m190523_102944_inser_user_rights
 */
class m190523_102944_inser_user_rights extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

        $this->execute("INSERT INTO `users_rights` (`id`, `name`) VALUES ('1', 'Оплата по счетам');");
        $this->execute("INSERT INTO `users_rights` (`id`, `name`) VALUES ('2', 'Добавление товаров');");

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190523_102944_inser_user_rights cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190523_102944_inser_user_rights cannot be reverted.\n";

        return false;
    }
    */
}
