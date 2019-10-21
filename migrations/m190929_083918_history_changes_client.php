<?php

use yii\db\Migration;

/**
 * Class m190929_083918_history_changes_client
 */
class m190929_083918_history_changes_client extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("CREATE TABLE `equipments_history` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `equipments_id` INT(11) NOT NULL,
  `type_change` INT(11) NOT NULL COMMENT 'тип изменения,',
  `old_params` VARCHAR(45) NULL COMMENT 'старое значение',
  `new_params` VARCHAR(45) NULL COMMENT 'новое значение',
  `reason` VARCHAR(450) NULL COMMENT 'Причина изменения',
  `date_create` DATETIME NULL DEFAULT NULL,
  PRIMARY KEY (`id`)) DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190929_083918_history_changes_client cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190929_083918_history_changes_client cannot be reverted.\n";

        return false;
    }
    */
}
