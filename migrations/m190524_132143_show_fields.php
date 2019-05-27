<?php

use yii\db\Migration;

/**
 * Class m190524_132143_show_fields
 */
class m190524_132143_show_fields extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("CREATE TABLE `show_field_client` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `user_id` int(11) DEFAULT NULL,
            `code` varchar(150) COLLATE utf8_bin NOT NULL COMMENT 'код поля',
            `name` varchar(150) COLLATE utf8_bin NOT NULL COMMENT 'наименование поля',
            `flag` int(5) NOT NULL COMMENT 'флаг отображения, 0-нет,1-да',
            PRIMARY KEY (`id`),
            KEY `fk_show_field_client_1_idx` (`user_id`),
            CONSTRAINT `fk_show_field_client_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
            ) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
        ");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190524_132143_show_fields cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190524_132143_show_fields cannot be reverted.\n";

        return false;
    }
    */
}
