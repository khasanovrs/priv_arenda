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
        `org_id` int(11) DEFAULT NULL,
        `status` int(11) NOT NULL,
        `last_contact` datetime NOT NULL COMMENT 'последний контакт',
        `source` int(11) NOT NULL COMMENT 'источник',
        `rentals` int(11) NOT NULL COMMENT 'прокаты',
        `dohod` int(100) NOT NULL COMMENT 'доход',
        `sale` int(11) NOT NULL COMMENT 'скидки',
        `date_create` datetime NOT NULL COMMENT 'дата создания записи',
        PRIMARY KEY (`id`),
        KEY `fk_client_fiz_1_idx` (`org_id`),
        KEY `fk_client_fiz_2_idx` (`source`),
        KEY `fk_client_fiz_3_idx` (`status`),
        CONSTRAINT `fk_client_fiz_1` FOREIGN KEY (`org_id`) REFERENCES `client_ur` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
        CONSTRAINT `fk_client_fiz_2` FOREIGN KEY (`source`) REFERENCES `client_source` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
        CONSTRAINT `fk_client_fiz_3` FOREIGN KEY (`status`) REFERENCES `client_status` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
        ) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
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
