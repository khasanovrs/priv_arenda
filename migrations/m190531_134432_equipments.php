<?php

use yii\db\Migration;

/**
 * Class m190531_134432_equipments
 */
class m190531_134432_equipments extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("CREATE TABLE `equipments` (
          `id` int(11) NOT NULL AUTO_INCREMENT,
          `mark` int(11) NOT NULL,
          `model` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
          `category_id` int(10) NOT NULL COMMENT 'идентификатор категории',
          `stock_id` int(11) NOT NULL,
          `type` int(11) NOT NULL COMMENT 'тип инструмента',
          `discount` int(11) NOT NULL,
          `status` int(11) DEFAULT NULL COMMENT 'Доступность',
          `count` varchar(45) CHARACTER SET utf8 DEFAULT NULL,
          `selling_price` varchar(45) COLLATE utf8_bin DEFAULT NULL COMMENT 'Цена продажи',
          `price_per_day` varchar(45) COLLATE utf8_bin DEFAULT NULL COMMENT 'Цена за сутки',
          `rentals` varchar(45) COLLATE utf8_bin DEFAULT NULL COMMENT 'Количество прокатов ',
          `repairs` varchar(45) COLLATE utf8_bin DEFAULT NULL COMMENT 'Количество ремонтов',
          `repairs_sum` varchar(45) COLLATE utf8_bin DEFAULT NULL COMMENT 'Сумма ремонтов',
          `tool_number` varchar(45) COLLATE utf8_bin DEFAULT NULL COMMENT 'Номер инструмента',
          `revenue` varchar(45) COLLATE utf8_bin DEFAULT NULL COMMENT 'Выручка',
          `profit` varchar(45) COLLATE utf8_bin DEFAULT NULL COMMENT 'Прибыль (выручка - цена покупки - ремонт)',
          `degree_wear` varchar(45) COLLATE utf8_bin DEFAULT NULL COMMENT 'Степень износа ',
          `payback_ratio` varchar(45) COLLATE utf8_bin DEFAULT NULL COMMENT 'Коэфициент окупаемости',
          `date_create` datetime DEFAULT NULL,
          PRIMARY KEY (`id`),
          KEY `fk_equipments_2_idx` (`stock_id`),
          KEY `fk_equipments_4_idx` (`type`),
          KEY `fk_equipments_1_idx` (`category_id`),
          KEY `fk_equipments_3_idx` (`status`),
          KEY `fk_equipments_6_idx` (`mark`),
          KEY `fk_equipments_7_idx` (`discount`),
          CONSTRAINT `fk_equipments_1` FOREIGN KEY (`category_id`) REFERENCES `equipments_category` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
          CONSTRAINT `fk_equipments_2` FOREIGN KEY (`stock_id`) REFERENCES `stock` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
          CONSTRAINT `fk_equipments_3` FOREIGN KEY (`status`) REFERENCES `equipments_status` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
          CONSTRAINT `fk_equipments_4` FOREIGN KEY (`type`) REFERENCES `equipments_type` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
          CONSTRAINT `fk_equipments_5` FOREIGN KEY (`status`) REFERENCES `equipments_status` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
          CONSTRAINT `fk_equipments_6` FOREIGN KEY (`mark`) REFERENCES `equipments_mark` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
          CONSTRAINT `fk_equipments_7` FOREIGN KEY (`discount`) REFERENCES `discount` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
        ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;
        ");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190531_134432_equipments cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190531_134432_equipments cannot be reverted.\n";

        return false;
    }
    */
}
