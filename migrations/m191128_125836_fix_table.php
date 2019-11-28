<?php

use yii\db\Migration;

/**
 * Class m191128_125836_fix_table
 */
class m191128_125836_fix_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("CREATE TABLE `equipments_demand` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `model` VARCHAR(150) COLLATE 'utf8mb4_unicode_ci' NOT NULL,
  `stock_id` INT(11) NOT NULL,
  INDEX `fk_equipments_demand_1_idx` (`stock_id` ASC),
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_equipments_demand_1`
    FOREIGN KEY (`stock_id`)
    REFERENCES `stock` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION);
");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m191128_125836_fix_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191128_125836_fix_table cannot be reverted.\n";

        return false;
    }
    */
}
