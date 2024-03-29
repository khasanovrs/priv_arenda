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
  `telephone` varchar(11) COLLATE utf8_bin NOT NULL COMMENT 'телефон пользователя',
  `status` varchar(45) COLLATE utf8_bin NOT NULL DEFAULT '0',
  `user_type` int(11) NOT NULL,
  `email` varchar(45) COLLATE utf8_bin DEFAULT NULL,
  `branch_id` int(11) NOT NULL COMMENT 'филиал',
  `password` varchar(500) CHARACTER SET utf8 NOT NULL COMMENT 'пароль пользователя',
  `date_create` datetime DEFAULT NULL COMMENT 'дата создания записи',
  `date_update` varchar(45) CHARACTER SET utf8 DEFAULT NULL COMMENT 'Время последнего запроса sms-кода',
  PRIMARY KEY (`id`),
  KEY `index2` (`telephone`),
  KEY `fk_users_1_idx` (`user_type`),
  KEY `fk_users_2_idx` (`branch_id`),
  CONSTRAINT `fk_users_1` FOREIGN KEY (`user_type`) REFERENCES `users_role` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_users_2` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
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
