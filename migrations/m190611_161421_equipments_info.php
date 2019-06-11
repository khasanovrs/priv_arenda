<?php

use yii\db\Migration;

/**
 * Class m190611_161421_equipments_info
 */
class m190611_161421_equipments_info extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("
            CREATE TABLE `equipments_info` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `equipments_id` int(11) NOT NULL,
            `power_energy` varchar(150) COLLATE utf8_bin DEFAULT NULL COMMENT 'ЭНЕРГИЯ УДАРА',
            `length` varchar(150) COLLATE utf8_bin DEFAULT NULL COMMENT 'ГАБАРИТНАЯ ДЛИНА',
            `network_cord` varchar(150) COLLATE utf8_bin DEFAULT NULL COMMENT 'СЕТЕВОЙ ШНУР',
            `power` varchar(150) COLLATE utf8_bin DEFAULT NULL COMMENT 'мощность',
            `frequency_hits` varchar(150) COLLATE utf8_bin DEFAULT NULL COMMENT 'ЧАСТОТА УДАРОВ',
            PRIMARY KEY (`id`),
            KEY `fk_equipments_info_1_idx` (`equipments_id`),
            CONSTRAINT `fk_equipments_info_1` FOREIGN KEY (`equipments_id`) REFERENCES `equipments` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
        ");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190611_161421_equipments_info cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190611_161421_equipments_info cannot be reverted.\n";

        return false;
    }
    */
}
