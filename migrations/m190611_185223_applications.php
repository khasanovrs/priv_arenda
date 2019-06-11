<?php

use yii\db\Migration;

/**
 * Class m190611_185223_applications
 */
class m190611_185223_applications extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("CREATE TABLE `applications` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `client_id` int(11) NOT NULL,
  `equipments_id` int(11) NOT NULL,
  `status_id` int(11) NOT NULL,
  `source_id` int(11) NOT NULL,
  `discount_id` int(11) NOT NULL,
  `delivery_id` int(11) NOT NULL,
  `comment` varchar(500) COLLATE utf8_bin DEFAULT NULL,
  `rent_start` datetime DEFAULT NULL,
  `rent_end` datetime DEFAULT NULL,
  `delivery_sum` int(15) DEFAULT NULL,
  `total_sum` int(15) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `a1_idx` (`client_id`),
  KEY `a2_idx` (`equipments_id`),
  KEY `a3_idx` (`source_id`),
  KEY `a4_idx` (`status_id`),
  KEY `a5_idx` (`discount_id`),
  KEY `a6_idx` (`delivery_id`),
  CONSTRAINT `a1` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`),
  CONSTRAINT `a2` FOREIGN KEY (`equipments_id`) REFERENCES `equipments` (`id`),
  CONSTRAINT `a3` FOREIGN KEY (`source_id`) REFERENCES `applications_source` (`id`),
  CONSTRAINT `a4` FOREIGN KEY (`status_id`) REFERENCES `applications_status` (`id`),
  CONSTRAINT `a5` FOREIGN KEY (`discount_id`) REFERENCES `discount` (`id`),
  CONSTRAINT `a6` FOREIGN KEY (`delivery_id`) REFERENCES `applications_delivery` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190611_185223_applications cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190611_185223_applications cannot be reverted.\n";

        return false;
    }
    */
}
