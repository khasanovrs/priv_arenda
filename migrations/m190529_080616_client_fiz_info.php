<?php

use yii\db\Migration;

/**
 * Class m190529_080616_client_fiz_info
 */
class m190529_080616_client_fiz_info extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("CREATE TABLE `client_fiz_info` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `client_id` int(11) DEFAULT NULL,
            `source` int(11) DEFAULT NULL COMMENT 'источник',
            `rentals` int(11) DEFAULT NULL COMMENT 'прокаты',
            `dohod` int(100) DEFAULT NULL COMMENT 'доход',
            `sale` int(11) DEFAULT NULL COMMENT 'скидки',
            `phone_chief` varchar(150) CHARACTER SET utf8 DEFAULT NULL,
            `phone_second` varchar(45) CHARACTER SET utf8 DEFAULT NULL,
            `date_create` datetime DEFAULT NULL COMMENT 'дата создания записи',
            `date_update` datetime DEFAULT NULL COMMENT 'дата создания записи',
            PRIMARY KEY (`id`),
            KEY `fk_client_fiz_info_1_idx` (`client_id`),
            KEY `fk_client_fiz_info_2_idx` (`source`),
            KEY `fk_client_fiz_info_3_idx` (`sale`),
            CONSTRAINT `fk_client_fiz_info_1` FOREIGN KEY (`client_id`) REFERENCES `client_fiz` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
            CONSTRAINT `fk_client_fiz_info_2` FOREIGN KEY (`source`) REFERENCES `client_source` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
            CONSTRAINT `fk_client_fiz_info_3` FOREIGN KEY (`sale`) REFERENCES `discount` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
    ");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190529_080616_client_fiz_info cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190529_080616_client_fiz_info cannot be reverted.\n";

        return false;
    }
    */
}
