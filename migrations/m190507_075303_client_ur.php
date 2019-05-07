<?php

use yii\db\Migration;

/**
 * Class m190507_075303_client_ur
 */
class m190507_075303_client_ur extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("CREATE TABLE `client_ur` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name_org` VARCHAR(150) NULL,
  `phone` INT(11) NULL,
  `status` INT(11) NULL,
  `last_contact` DATETIME NULL DEFAULT NULL COMMENT 'последний контакт',
  `source` INT(11) NULL COMMENT 'источник',
  `rentals` INT(11) NULL COMMENT 'прокаты',
  `dohod` INT(100) NULL COMMENT 'доход',
  `sale` INT(11) NULL COMMENT 'скидки',
  `date_create` DATETIME NULL DEFAULT NULL COMMENT 'дата создания записи',
  INDEX `fk_client_ur_1_idx` (`source` ASC),
  INDEX `fk_client_ur_2_idx` (`status` ASC),
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_client_ur_1`
    FOREIGN KEY (`source`)
    REFERENCES `client_source` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_client_ur_2`
    FOREIGN KEY (`status`)
    REFERENCES `client_status` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION);
        ");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190507_075303_client_ur cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190507_075303_client_ur cannot be reverted.\n";

        return false;
    }
    */
}
