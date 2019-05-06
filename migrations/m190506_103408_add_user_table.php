<?php

use yii\db\Migration;

/**
 * Class m190506_103408_add_user_table
 */
class m190506_103408_add_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("CREATE TABLE `users` (
          `id` int(11) NOT NULL AUTO_INCREMENT,
          `fio` varchar(100) COLLATE utf8_bin NOT NULL COMMENT 'фио пользователя',
          `telephone` int(11) NOT NULL COMMENT 'телефон пользователя',
          `status` varchar(11) COLLATE utf8_bin NOT NULL DEFAULT '0'  COMMENT 'статус пользователя, 0-активен,1-заблокирован',
          `email` int(45) NOT NULL COMMENT 'email пользователя',
          `password` varchar(45) COLLATE utf8_bin NOT NULL COMMENT 'пароль пользователя',
          `date_create` datetime DEFAULT NULL COMMENT 'дата создания записи',
          `date_update` datetime DEFAULT NULL,
          PRIMARY KEY (`id`),
          KEY `index2` (`telephone`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
        ");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190506_103408_add_user_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190506_103408_add_user_table cannot be reverted.\n";

        return false;
    }
    */
}
