<?php

use yii\db\Migration;

/**
 * Class m190927_072941_add_change_client_status
 */
class m190927_072941_add_change_client_status extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
$this->execute("CREATE TABLE `client_status_change` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `client_id` INT(11) NOT NULL,
  `old_status` INT(11) NOT NULL,
  `new_status` INT(11) NOT NULL,
  `text` VARCHAR(500) NOT NULL,
  `date` DATETIME NULL DEFAULT NULL COMMENT 'последний контакт',
  PRIMARY KEY (`id`),
  INDEX `fk_client_status_change_1_idx` (`client_id` ASC),
  INDEX `fk_client_status_change_2_idx` (`old_status` ASC),
  INDEX `fk_client_status_change_3_idx` (`new_status` ASC),
  CONSTRAINT `fk_client_status_change_1`
    FOREIGN KEY (`client_id`)
    REFERENCES `clients` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_client_status_change_2`
    FOREIGN KEY (`old_status`)
    REFERENCES `client_status` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_client_status_change_3`
    FOREIGN KEY (`new_status`)
    REFERENCES `client_status` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION) DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190927_072941_add_change_client_status cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190927_072941_add_change_client_status cannot be reverted.\n";

        return false;
    }
    */
}
