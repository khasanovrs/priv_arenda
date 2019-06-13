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
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `name` varchar(55) COLLATE utf8_bin NOT NULL,
            PRIMARY KEY (`id`)
            ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
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
