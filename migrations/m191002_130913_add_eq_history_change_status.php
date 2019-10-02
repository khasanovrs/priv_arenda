<?php

use yii\db\Migration;

/**
 * Class m191002_130913_add_eq_history_change_status
 */
class m191002_130913_add_eq_history_change_status extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("CREATE TABLE `equipments_history_change_status` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `equipments_id` INT(11) NOT NULL,
  `old_status` INT(11) NOT NULL COMMENT 'старое значение',
  `new_status` INT(11) NOT NULL COMMENT 'новое значение',
  `reason` VARCHAR(450) CHARACTER SET 'utf8' NOT NULL COMMENT 'Причина изменения',
  `date_create` DATETIME NULL DEFAULT NULL,
  `user_id` INT(11) NOT NULL,
  `sum` VARCHAR(45) NULL,
  `cashBox_id` INT(11) NULL,
  INDEX `fk_equipments_history_change_status_1_idx` (`equipments_id` ASC),
  INDEX `fk_equipments_history_change_status_2_idx` (`old_status` ASC),
  INDEX `fk_equipments_history_change_status_3_idx` (`new_status` ASC),
  INDEX `fk_equipments_history_change_status_4_idx` (`user_id` ASC),
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_equipments_history_change_status_1`
    FOREIGN KEY (`equipments_id`)
    REFERENCES `equipments` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_equipments_history_change_status_2`
    FOREIGN KEY (`old_status`)
    REFERENCES `equipments_status` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_equipments_history_change_status_3`
    FOREIGN KEY (`new_status`)
    REFERENCES `equipments` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_equipments_history_change_status_4`
    FOREIGN KEY (`user_id`)
    REFERENCES `users` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION);
");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m191002_130913_add_eq_history_change_status cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191002_130913_add_eq_history_change_status cannot be reverted.\n";

        return false;
    }
    */
}
