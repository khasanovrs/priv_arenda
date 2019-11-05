<?php

use yii\db\Migration;

/**
 * Class m191105_084000_add_user
 */
class m191105_084000_add_user extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("INSERT INTO `users` (`id`, `fio`, `telephone`, `status`, `user_type`, `email`, `branch_id`, `password`) VALUES ('1', 'Иванов Иван', '79173936213', '1', '1', '', '1', '\$2y$10\$n9RUv5blmdiMI5I42Jjqm.o7n/CZ0DFh5dkVz/VCnbOEM/H3SaZoq');");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m191105_084000_add_user cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191105_084000_add_user cannot be reverted.\n";

        return false;
    }
    */
}
