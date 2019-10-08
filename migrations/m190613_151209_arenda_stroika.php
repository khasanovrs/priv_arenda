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
          `id` INT(11) NOT NULL AUTO_INCREMENT,
          `application_id` INT(11) NOT NULL,
          `equipments_id` INT(11) NOT NULL,
          `equipments_count` INT(11) NOT NULL,
          PRIMARY KEY (`id`),
          INDEX `fk_application_equipment_1_idx` (`application_id` ASC),
          INDEX `fk_application_equipment_2_idx` (`equipments_id` ASC),
          CONSTRAINT `fk_application_equipment_1`
            FOREIGN KEY (`application_id`)
            REFERENCES `applications` (`id`)
            ON DELETE NO ACTION
            ON UPDATE NO ACTION,
          CONSTRAINT `fk_application_equipment_2`
            FOREIGN KEY (`equipments_id`)
            REFERENCES `equipments` (`id`)
            ON DELETE NO ACTION
            ON UPDATE NO ACTION)
            ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
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
