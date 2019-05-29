<?php

use yii\db\Migration;

/**
 * Class m190529_071826_client_ur_info
 */
class m190529_071826_client_ur_info extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("CREATE TABLE `client_ur_info` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `client_id` int(11) DEFAULT NULL,
            `source` int(11) DEFAULT NULL COMMENT 'источник',
            `rentals` int(11) DEFAULT NULL COMMENT 'прокаты',
            `dohod` int(100) DEFAULT NULL COMMENT 'доход',
            `sale` int(11) DEFAULT NULL COMMENT 'скидки',
            `address` varchar(45) COLLATE utf8_bin DEFAULT NULL,
            `name_org` varchar(450) COLLATE utf8_bin DEFAULT NULL,
            `inn` varchar(20) COLLATE utf8_bin DEFAULT NULL,
            `occupation` varchar(450) COLLATE utf8_bin DEFAULT NULL,
            `ogrn` varchar(45) COLLATE utf8_bin DEFAULT NULL,
            `bic` varchar(45) COLLATE utf8_bin DEFAULT NULL,
            `kpp` varchar(45) COLLATE utf8_bin DEFAULT NULL,
            `schet` varchar(45) COLLATE utf8_bin DEFAULT NULL,
            `name_chief` varchar(150) COLLATE utf8_bin DEFAULT NULL,
            `phone_chief` varchar(150) COLLATE utf8_bin DEFAULT NULL,
            `phone_second` varchar(45) COLLATE utf8_bin DEFAULT NULL,
            `date_create` datetime DEFAULT NULL COMMENT 'дата создания записи',
            `date_update` datetime DEFAULT NULL COMMENT 'дата создания записи',
            PRIMARY KEY (`id`),
            KEY `fk_client_ur_info_1_idx` (`client_id`),
            KEY `fk_client_ur_info_2_idx` (`sale`),
            KEY `fk_client_ur_info_3_idx` (`source`),
            CONSTRAINT `fk_client_ur_info_1` FOREIGN KEY (`client_id`) REFERENCES `client_ur` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
            CONSTRAINT `fk_client_ur_info_2` FOREIGN KEY (`sale`) REFERENCES `discount` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
            CONSTRAINT `fk_client_ur_info_3` FOREIGN KEY (`source`) REFERENCES `client_source` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
      ");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190529_071826_client_ur_info cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190529_071826_client_ur_info cannot be reverted.\n";

        return false;
    }
    */
}
