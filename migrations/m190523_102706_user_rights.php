<?php

use yii\db\Migration;

/**
 * Class m190523_102706_user_rights
 */
class m190523_102706_user_rights extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute('CREATE TABLE `users_rights` (
          `id` INT(11) NOT NULL AUTO_INCREMENT,
          `name` VARCHAR(55) NOT NULL,
          PRIMARY KEY (`id`));
        ');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190523_102706_user_rights cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190523_102706_user_rights cannot be reverted.\n";

        return false;
    }
    */
}
