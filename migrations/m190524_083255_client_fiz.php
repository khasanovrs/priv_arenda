<?php

use yii\db\Migration;

/**
 * Class m190524_083255_client_fiz
 */
class m190524_083255_client_fiz extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
    $this->execute("CREATE TABLE `client_fiz` (
          `id` int(11) NOT NULL AUTO_INCREMENT,
          `fio` varchar(150) CHARACTER SET utf8 NOT NULL,
          `phone` varchar(11) CHARACTER SET utf8 NOT NULL,
          `status` int(11) NOT NULL,
          `branch_id` int(11) DEFAULT NULL,
          `last_contact` datetime NOT NULL COMMENT 'последний контакт',
          `date_create` datetime NOT NULL COMMENT 'дата создания записи',
          PRIMARY KEY (`id`),
          KEY `fk_client_fiz_1_idx` (`org_id`),
          KEY `fk_client_fiz_3_idx` (`status`),
          KEY `fk_client_fiz_2_idx` (`branch_id`),
          CONSTRAINT `fk_client_fiz_1` FOREIGN KEY (`org_id`) REFERENCES `client_ur` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
          CONSTRAINT `fk_client_fiz_2` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
          CONSTRAINT `fk_client_fiz_3` FOREIGN KEY (`status`) REFERENCES `client_status` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
        ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
    ");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190524_083255_client_fiz cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190524_083255_client_fiz cannot be reverted.\n";

        return false;
    }
    */
}
