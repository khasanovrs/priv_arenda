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
        $this->execute("CREATE TABLE `client_ur` (
          `id` int(11) NOT NULL AUTO_INCREMENT,
          `name_org` varchar(150) COLLATE utf8_bin DEFAULT NULL,
          `phone` varchar(11) COLLATE utf8_bin DEFAULT NULL,
          `status` int(11) DEFAULT NULL,
          `branch_id` int(11) DEFAULT NULL,
          `last_contact` datetime DEFAULT NULL COMMENT 'последний контакт',
          `date_create` datetime DEFAULT NULL COMMENT 'дата создания записи',
          PRIMARY KEY (`id`),
          KEY `fk_client_ur_2_idx` (`status`),
          KEY `fk_client_ur_1_idx` (`branch_id`),
          CONSTRAINT `fk_client_ur_1` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
          CONSTRAINT `fk_client_ur_2` FOREIGN KEY (`status`) REFERENCES `client_status` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
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
