<?php

use yii\db\Migration;

/**
 * Class m190707_075601_finance
 */
class m190707_075601_finance extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
$this->execute("CREATE TABLE `finance` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(150) COLLATE utf8_bin NOT NULL,
  `category_id` int(11) NOT NULL,
  `type_id` int(11) NOT NULL,
  `date_create` datetime DEFAULT NULL,
  `payer_id` int(11) NOT NULL,
  `sum` varchar(45) COLLATE utf8_bin NOT NULL DEFAULT '0',
  `cashBox_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fin_idx` (`category_id`),
  KEY `fin_1_idx` (`type_id`),
  KEY `fin_2_idx` (`payer_id`),
  KEY `fin_3_idx` (`cashBox_id`),
  CONSTRAINT `fin` FOREIGN KEY (`category_id`) REFERENCES `finance_category` (`id`),
  CONSTRAINT `fin_1` FOREIGN KEY (`type_id`) REFERENCES `finance_type` (`id`),
  CONSTRAINT `fin_2` FOREIGN KEY (`payer_id`) REFERENCES `clients` (`id`),
  CONSTRAINT `fin_3` FOREIGN KEY (`cashBox_id`) REFERENCES `finance_cashbox` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190707_075601_finance cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190707_075601_finance cannot be reverted.\n";

        return false;
    }
    */
}
