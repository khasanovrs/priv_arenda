<?php

use yii\db\Migration;

/**
 * Class m190507_075303_client
 */
class m190507_075303_client extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("CREATE TABLE `clients` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(150) CHARACTER SET utf8 NOT NULL,
  `type` int(5) NOT NULL DEFAULT '1' COMMENT 'тип клиента,1-физ. лицо, 2-юр. лицо',
  `phone` varchar(11) CHARACTER SET utf8 NOT NULL,
  `status` int(11) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `last_contact` datetime DEFAULT NULL COMMENT 'последний контакт',
  `date_create` datetime DEFAULT NULL COMMENT 'дата создания записи',
  PRIMARY KEY (`id`),
  KEY `fk_clients_1_idx` (`branch_id`),
  KEY `fk_clients_2_idx` (`status`),
  CONSTRAINT `fk_clients_1` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_clients_2` FOREIGN KEY (`status`) REFERENCES `client_status` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
        ");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190507_075303_client_ur cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190507_075303_client_ur cannot be reverted.\n";

        return false;
    }
    */
}
