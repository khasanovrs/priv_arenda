<?php

use yii\db\Migration;

/**
 * Class m190506_114506_add_table_session
 */
class m190506_114506_add_table_session extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("CREATE TABLE `session` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `session_date` timestamp NULL DEFAULT NULL COMMENT 'дата создания сессии',
  `session_date_end` varchar(45) COLLATE utf8_bin DEFAULT NULL,
  `session_id` varchar(250) COLLATE utf8_bin DEFAULT NULL,
  `status` varchar(45) COLLATE utf8_bin DEFAULT NULL COMMENT 'статус сессии',
  PRIMARY KEY (`id`),
  KEY `fk_session_1_idx` (`user_id`),
  CONSTRAINT `fk_session_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
        ");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190506_114506_add_table_session cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190506_114506_add_table_session cannot be reverted.\n";

        return false;
    }
    */
}
