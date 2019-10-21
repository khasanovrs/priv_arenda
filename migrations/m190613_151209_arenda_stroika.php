<?php

use yii\db\Migration;

/**
 * Class m190613_151209_arenda_stroika
 */
class m190613_151209_arenda_stroika extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("CREATE TABLE `application_equipment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `status_id` int(11) NOT NULL,
  `hire_status_id` int(11) NOT NULL DEFAULT '1',
  `hire_state_id` int(11) NOT NULL,
  `application_id` int(11) NOT NULL,
  `equipments_id` int(11) NOT NULL,
  `equipments_count` int(11) NOT NULL,
  `delivery_sum` varchar(45) COLLATE utf8_bin NOT NULL DEFAULT '0',
  `sum` varchar(45) COLLATE utf8_bin NOT NULL,
  `sum_sale` varchar(45) COLLATE utf8_bin NOT NULL DEFAULT '0',
  `total_paid` varchar(45) COLLATE utf8_bin NOT NULL DEFAULT '0',
  `remainder` varchar(45) COLLATE utf8_bin NOT NULL DEFAULT '0',
  `hire_date` datetime DEFAULT NULL,
  `renewals_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_application_equipment_1_idx` (`application_id`),
  KEY `fk_application_equipment_2_idx` (`equipments_id`),
  KEY `fk_application_equipment_3_idx` (`status_id`),
  KEY `fk_application_equipment_5_idx` (`hire_state_id`),
  CONSTRAINT `fk_application_equipment_1` FOREIGN KEY (`application_id`) REFERENCES `applications` (`id`),
  CONSTRAINT `fk_application_equipment_2` FOREIGN KEY (`equipments_id`) REFERENCES `equipments` (`id`),
  CONSTRAINT `fk_application_equipment_3` FOREIGN KEY (`status_id`) REFERENCES `applications_status` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190613_151209_arenda_stroika cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190613_151209_arenda_stroika cannot be reverted.\n";

        return false;
    }
    */
}
