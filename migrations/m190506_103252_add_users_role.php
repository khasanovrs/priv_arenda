<?php

use yii\db\Migration;

/**
 * Class m190506_103252_add_users_role
 */
class m190506_103252_add_users_role extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("CREATE TABLE `users_role` (
            `id` INT(11) NOT NULL AUTO_INCREMENT,
            `name` VARCHAR(55) NOT NULL,
            PRIMARY KEY (`id`));
          ");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190507_072252_add_users_role cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190507_072252_add_users_role cannot be reverted.\n";

        return false;
    }
    */
}
